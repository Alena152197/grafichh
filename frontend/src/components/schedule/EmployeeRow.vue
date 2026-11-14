<template>
  <div
  class="row"
  :class="{ alt }"
  :style="{
  gridTemplateColumns: `220px repeat(${dates.length}, ${dayCol})`,
  width: 'max-content',
  }"
  >
    <div class="employee">
      <div class="avatar">
          <img
            :src="`https://i.pravatar.cc/64?u=${employee.id}`"
            :alt="employee.full_name"
          />
      </div>
      <div class="meta">
        <span class="name">{{ employee.full_name }}</span>
        <span class="role">агент · 24ч</span>
      </div>
    </div>

    <ShiftCell
      v-for="date in dates"
      :key="date"
      :employee-id="employee.id"
      :date="date"
      :shift="store.shiftAt(employee.id, date)"
      :selected="store.isSelected(employee.id, date)"
      :compact="compact"
    />
  </div>
</template>

<script setup lang="ts">
import type { Employee } from '@/types'
import ShiftCell from './ShiftCell.vue'
import { useScheduleStore } from '@/stores/scheduleStore'

defineProps<{
  employee: Employee
  dates: string[]
  dayCol: string
  compact?: boolean
  alt?: boolean
}>()

const store = useScheduleStore()
</script>

<style scoped>
.row {
  display: grid;
  align-items: stretch;
  width: max-content;
  gap: 0;
  padding: 0;
  box-sizing: border-box;
}
.employee {
  position: sticky;
  left: 0;
  z-index: 2;
  background: #FFFFFF;
  width: 220px;
  height: 72px;
  box-sizing: border-box;
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px 12px 12px 8px;
}
.avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  overflow: hidden;
  flex-shrink: 0;
  background: #e5e7eb;
}
.avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
.meta {
  width: 152px;
  height: 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 0;
  min-width: 0;
}
.name {
  height: 24px;
  font-weight: 400;
  font-size: 14px;
  line-height: 20px;
  color: #000000;
  display: flex;
  align-items: center;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.role {
  height: 16px;
  font-weight: 400;
  font-size: 12px;
  line-height: 16px;
  color: #737378;
  display: flex;
  align-items: center;
}
.row.alt {
  background: #F8F9FB;
}
.row.alt .employee,
.row.alt :deep(.day-col) {
  background: #F8F9FB;
}
.row.alt .employee {
  background: #F8F9FB;
}
.row.alt :deep(.shift-cell:not(.filled)) {
  background: #F8F9FB;
}
.row.alt :deep(.shift-cell.filled) {
  background: unset;
}
.row.alt :deep(.day-col.selected) {
  background: #EBEFFD;
}
.row.alt :deep(.day-col.selected .shift-cell:not(.filled)) {
  background: transparent;
}
.row.alt :deep(.shift-cell.selected) {
  background: #eff6ff;
}
</style>