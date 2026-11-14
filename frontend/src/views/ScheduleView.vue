<template>
  <div class="app-shell">
    <AppSidebar />
  <main class="main">
  <AppHeader @save="onSave" @publish="onPublish" />

  <p v-if="store.loading" class="loading">Загрузка...</p>

  <div v-else class="board">
    <SelectionBar
      v-if="store.selectedCells.length"
      :cells-count="store.selectedCells.length"
      :employees-count="selectedEmployeesCount"
      :days-count="selectedDaysCount"
      @apply="onApplyTemplate"
      @clear="onClearSelected"
      @deselect="onDeselect"
    />
    <ScheduleToolbar
      v-else
      :search="store.search"
      :view-mode="store.viewMode"
      @update:search="store.setSearch"
      @update:view-mode="(mode) => store.setViewMode(mode)"
    />
    <ScheduleGrid />
  </div>
  </main>
    <TemplatesPanel />
  </div>
</template>

<script setup lang="ts">
import { onMounted, onBeforeUnmount } from 'vue'
import AppSidebar from '@/components/layout/AppSidebar.vue'
import AppHeader from '@/components/layout/AppHeader.vue'
import ScheduleToolbar from '@/components/schedule/ScheduleToolbar.vue'
import ScheduleGrid from '@/components/schedule/ScheduleGrid.vue'
import TemplatesPanel from '@/components/templates/TemplatesPanel.vue'
import { useScheduleStore } from '@/stores/scheduleStore'
import { computed } from 'vue'
import SelectionBar from '@/components/schedule/SelectionBar.vue'

const store = useScheduleStore()

const selectedEmployeesCount = computed(() => {
  return new Set(store.selectedCells.map((c) => c.employee_id)).size
})
const selectedDaysCount = computed(() => {
  return new Set(store.selectedCells.map((c) => c.date)).size
})

async function onSave() {
  const res = await store.save()
  alert(res.message ?? 'Сохранено')
}

async function onPublish() {
  const res = await store.publish()
  alert(res.message ?? 'Опубликовано')
}

function onKeyDown(e: KeyboardEvent) {
  if (e.key !== 'Delete' && e.key !== 'Backspace') return

  const tag = (e.target as HTMLElement)?.tagName
  if (tag === 'INPUT' || tag === 'TEXTAREA') return

  const selected = store.selectedCells
  if (!selected.length) return

  e.preventDefault()

  for (const cell of [...selected]) {
    const shift = store.shiftAt(cell.employee_id, cell.date)
    if (shift) {
      void store.removeShift(shift.id)
    }
  }

  store.selectedCells = []
}

function onApplyTemplate() {
  const template = store.templates[0]
  if (!template) return
  void store.applyTemplate(template)
}
async function onClearSelected() {
  for (const cell of [...store.selectedCells]) {
    const shift = store.shiftAt(cell.employee_id, cell.date)
    if (shift) await store.removeShift(shift.id)
  }
  store.selectedCells = []
}
function onDeselect() {
  store.selectedCells = []
}

onMounted(() => {
  void store.loadAll()
  window.addEventListener('keydown', onKeyDown)
})

onBeforeUnmount(() => {
  window.removeEventListener('keydown', onKeyDown)
})
</script>

<style scoped>
.app-shell {
  display: grid;
  grid-template-columns: var(--sidebar-w) 1fr var(--templates-w);
  min-height: 100vh;
}
.main {
  padding: 20px 24px;
  overflow: auto;
}
.loading {
  margin-top: 24px;
}
.board {
  margin-top: 16px;
  width: 100%;
  max-width: 1580px;
  min-height: 740px;
  border-radius: 24px;
  padding: 12px;
  gap: 20px;
  background: #FFFFFF;
  display: flex;
  flex-direction: column;
  box-sizing: border-box;
  overflow: hidden;
}
</style>