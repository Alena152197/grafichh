<template>
  <div class="grid-wrap" @click="closeMenu">
    <div class="header" :style="gridStyle">
      <div class="corner">Сотрудник</div>
      <div
        v-for="(day, i) in store.days"
        :key="store.daysISO[i]"
        class="day"
        @click.stop="openMenu($event, store.daysISO[i])"
      >
        {{ dayLabel(day, store.viewMode) }}
      </div>
    </div>

    <EmployeeRow
      v-for="(employee, index) in store.filteredEmployees"
      :key="employee.id"
      :employee="employee"
      :dates="store.daysISO"
      :compact="compact"
      :alt="index % 2 === 1"
      :day-col="dayCol"
    />

    <CoverageRow
      :dates="store.daysISO"
      :coverage="store.coverage"
      :day-col="dayCol"
    />

    <QuickShiftMenu
      v-if="menu"
      :templates="store.templates"
      :x="menu.x"
      :y="menu.y"
      @pick="onPick"
    />
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import EmployeeRow from './EmployeeRow.vue'
import CoverageRow from './CoverageRow.vue'
import QuickShiftMenu from './QuickShiftMenu.vue'
import { useScheduleStore } from '@/stores/scheduleStore'
import { dayLabel } from '@/composables/useDateRange'
import type { ShiftTemplate } from '@/types'

const store = useScheduleStore()

const dayCol = computed(() =>
  store.viewMode === 'month'
    ? 'calc((100cqw - 220px) / 12)'
    : 'calc((100cqw - 220px) / 7)',
)

const gridStyle = computed(() => ({
  gridTemplateColumns: `220px repeat(${store.daysISO.length}, ${dayCol.value})`,
  width: 'max-content',
}))

const compact = computed(() => store.viewMode === 'month')

const menu = ref<{ date: string; x: number; y: number } | null>(null)

function openMenu(e: MouseEvent, date: string) {
  menu.value = {
    date,
    x: e.clientX,
    y: e.clientY + 8,
  }
}

function closeMenu() {
  menu.value = null
}

async function onPick(template: ShiftTemplate) {
  if (!menu.value) return
  const date = menu.value.date
  menu.value = null
  await store.applyTemplateToDate(template, date)
}
</script>

<style scoped>
.grid-wrap {
  width: 100%;
  overflow-x: auto;
  scrollbar-width: none;
  container-type: inline-size;
  position: relative;
}
.grid-wrap::-webkit-scrollbar {
  display: none;
}
.header {
  display: grid;
  align-items: stretch;
  height: 48px;
  width: max-content;
}
.corner {
  position: sticky;
  left: 0;
  z-index: 3;
  background: #FFFFFF;
  width: 220px;
  height: 48px;
  padding: 12px;
  box-sizing: border-box;
  border-bottom: 1px solid #DEDEE3;
  font-size: 14px;
  line-height: 20px;
  color: #101012;
  display: flex;
  align-items: center;
}
.day {
  width: 100%;
  min-width: 0;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  line-height: 20px;
  color: #101012;
  text-transform: lowercase;
  cursor: pointer;
  border-radius: 8px;
}
.day:hover {
  background: #F2F3F7;
}
</style>