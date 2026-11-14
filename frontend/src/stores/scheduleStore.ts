import { defineStore } from 'pinia'
import { computed, ref } from 'vue'
import type { CellKey, Employee, Shift, ShiftTemplate, ViewMode } from '@/types'
import {
  bulkAssign,
  deleteShift,
  fetchEmployees,
  fetchShifts,
  fetchTemplates,
  moveShift,
  publishSchedule,
  saveSchedule,
} from '@/api/client'
import { getRange, shiftAnchor, toISODate } from '@/composables/useDateRange'
import { useCoverage } from '@/composables/useCoverage'

const SCHEDULE_ID = 1

export const useScheduleStore = defineStore('schedule', () => {
  const employees = ref<Employee[]>([])
  const templates = ref<ShiftTemplate[]>([])
  const shifts = ref<Shift[]>([])
  const search = ref('')
  const viewMode = ref<ViewMode>('week')
  const anchorDate = ref(new Date())
  const selectedCells = ref<CellKey[]>([])
  const loading = ref(false)

  const range = computed(() => getRange(anchorDate.value, viewMode.value))
  const days = computed(() => range.value.days)
  const daysISO = computed(() => days.value.map(toISODate))
  const coverage = useCoverage(shifts, daysISO)

  const filteredEmployees = computed(() => {
    const q = search.value.trim().toLowerCase()
    if (!q) return employees.value
    return employees.value.filter((e) => e.full_name.toLowerCase().includes(q))
  })

  function shiftAt(employeeId: number, date: string) {
    return shifts.value.find((s) => s.employee_id === employeeId && s.date === date)
  }

  function isSelected(employeeId: number, date: string) {
    return selectedCells.value.some(
      (c) => c.employee_id === employeeId && c.date === date,
    )
  }

  function toggleCell(employeeId: number, date: string, multi = false) {
    const idx = selectedCells.value.findIndex(
      (c) => c.employee_id === employeeId && c.date === date,
    )
    if (idx >= 0) {
      selectedCells.value.splice(idx, 1)
      return
    }
    if (!multi) selectedCells.value = []
    selectedCells.value.push({ employee_id: employeeId, date })
  }

  async function loadAll() {
    loading.value = true
    try {
      const [emps, tmpls] = await Promise.all([fetchEmployees(), fetchTemplates()])
      employees.value = emps
      templates.value = tmpls
      await loadShifts()
    } finally {
      loading.value = false
    }
  }

  async function loadShifts() {
    const from = toISODate(range.value.from)
    const to = toISODate(range.value.to)
    shifts.value = await fetchShifts(SCHEDULE_ID, from, to)
  }

  async function applyTemplate(template: ShiftTemplate, cells?: CellKey[]) {
    const targets = cells ?? selectedCells.value
    if (!targets.length) return

    await bulkAssign(SCHEDULE_ID, {
      cells: targets,
      shift_template_id: template.id,
      start_time: template.start_time.slice(0, 5),
      end_time: template.end_time.slice(0, 5),
      duration_hours: template.duration_hours,
    })
    await loadShifts()
    selectedCells.value = []
  }

  async function applyTemplateToDate(template: ShiftTemplate, date: string) {
    const cells = filteredEmployees.value.map((e) => ({
      employee_id: e.id,
      date,
    }))
    await applyTemplate(template, cells)
  }

  async function applyCustom(start: string, end: string, hours: number) {
    if (!selectedCells.value.length) return
    await bulkAssign(SCHEDULE_ID, {
      cells: selectedCells.value,
      shift_template_id: null,
      start_time: start,
      end_time: end,
      duration_hours: hours,
    })
    await loadShifts()
    selectedCells.value = []
  }

  async function onDropShift(shiftId: number, employeeId: number, date: string) {
    await moveShift(SCHEDULE_ID, {
      shift_id: shiftId,
      employee_id: employeeId,
      date,
    })
    await loadShifts()
  }

  async function removeShift(shiftId: number) {
    await deleteShift(shiftId)
    await loadShifts()
  }

  async function save() {
    return saveSchedule(SCHEDULE_ID)
  }

  async function publish() {
    return publishSchedule(SCHEDULE_ID)
  }

  function setViewMode(mode: ViewMode) {
    viewMode.value = mode
    void loadShifts()
  }

  function navigate(dir: -1 | 1) {
    anchorDate.value = shiftAnchor(anchorDate.value, viewMode.value, dir)
    void loadShifts()
  }

  function setSearch(q: string) {
    search.value = q
  }

  return {
  employees,
  templates,
  shifts,
  search,
  viewMode,
  anchorDate,
  selectedCells,
  loading,
  days,
  daysISO,
  coverage,
  filteredEmployees,
  shiftAt,
  isSelected,
  toggleCell,
  loadAll,
  loadShifts,
  applyTemplate,
  applyTemplateToDate,
  applyCustom,
  onDropShift,
  removeShift,
  save,
  publish,
  setViewMode,
  navigate,
  setSearch,
  }
})