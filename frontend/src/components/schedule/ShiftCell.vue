<template>
  <div
    class="day-col"
    :class="{ selected, compact }"
    @click="onClick"
    @dragover="onDragOver"
    @drop="onDrop"
  >
    <div
      class="shift-cell"
      :class="{
        filled: !!shift,
        compact,
        'is-custom': !!shift && !shift.shift_template_id && !shift.template,
      }"
      :style="shift ? { background: fillColor } : undefined"
    >
      <div
        v-if="shift"
        class="chip"
        draggable="true"
        @dragstart.stop="onDragStart"
      >
        <span v-if="!compact" class="time">
          {{ shift.start_time.slice(0, 5) }}
        </span>
        <span class="hours">{{ shift.duration_hours }}ч</span>
    </div>


      <div v-else-if="selected" class="plus-wrap">
        <span class="plus-circle">
          <svg viewBox="0 0 10 10" width="10" height="10" fill="none">
            <path
              d="M5 1v8M1 5h8"
              stroke="#FFFFFF"
              stroke-width="1.08"
              stroke-linecap="round"
            />
          </svg>
        </span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { Shift } from '@/types'
import { useScheduleStore } from '@/stores/scheduleStore'

const props = defineProps<{
  employeeId: number
  date: string
  shift?: Shift
  selected: boolean
  compact?: boolean
}>()

const store = useScheduleStore()

const fillColor = computed(() => {
  if (!props.shift) return undefined

  const slug =
    props.shift.template?.slug ??
    store.templates.find((t) => t.id === props.shift?.shift_template_id)?.slug

  if (slug === 'morning') return '#BBC9F7'
  if (slug === 'day') return '#C8ADFF'
  if (slug === 'evening') return '#B2EEEB'
  return '#5B7DEC'
})

function onClick(e: MouseEvent) {
  store.toggleCell(props.employeeId, props.date, e.metaKey || e.ctrlKey || e.shiftKey)
}

function onDragStart(e: DragEvent) {
  if (!props.shift) return
  e.dataTransfer?.setData(
    'application/json',
    JSON.stringify({ type: 'shift', id: props.shift.id }),
  )
}

function onDragOver(e: DragEvent) {
  e.preventDefault()
}

function onDrop(e: DragEvent) {
  e.preventDefault()
  const raw = e.dataTransfer?.getData('application/json')
  if (!raw) return

  const data = JSON.parse(raw) as { type: 'template' | 'shift'; id: number }

  if (data.type === 'shift') {
    void store.onDropShift(data.id, props.employeeId, props.date)
    return
  }

  if (data.type === 'template') {
    const tpl = store.templates.find((t) => t.id === data.id)
    if (tpl) {
      void store.applyTemplate(tpl, [
        { employee_id: props.employeeId, date: props.date },
      ])
    }
  }
}
</script>

<style scoped>
.day-col {
  width: 100%;
  min-width: 0;
  height: 72px;
  box-sizing: border-box;
  padding: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.day-col.compact {
  height: 56px;
  padding: 2px;
}
.day-col.selected {
  background: #EBEFFD;
  border: 1px solid #5B7DEC;
}
.shift-cell {
  width: 100%;
  max-width: 102px;
  height: 64px;
  box-sizing: border-box;
  padding: 4px;
  border-radius: 8px;
  border: 1px dashed #DEDEE3;
  background: #fff;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}
.day-col.compact .shift-cell {
  padding: 2px;
  border-radius: 6px;
}
.shift-cell.filled {
  border: none;
}
.shift-cell.filled .chip {
  color: #3a3a8a;
}
.shift-cell.filled.is-custom .chip {
  color: #FFFFFF;
}
.day-col.selected .shift-cell:not(.filled) {
  border-color: transparent;
  background: transparent;
}
.plus-wrap {
  display: grid;
  place-items: center;
}
.plus-circle {
  width: 20px;
  height: 20px;
  border-radius: 99px;
  background: #5B7DEC;
  display: grid;
  place-items: center;
}
.day-col.compact .plus-circle {
  width: 16px;
  height: 16px;
}
.chip {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 2px;
  width: 100%;
  padding: 0;
  border: none;
  background: transparent;
  cursor: grab;
}
.chip:active {
  cursor: grabbing;
}
.time {
  font-size: 12px;
  font-weight: 600;
  line-height: 16px;
  white-space: nowrap;
}
.hours {
  font-size: 12px;
  font-weight: 400;
  line-height: 16px;
  white-space: nowrap;
}
.day-col.compact .hours {
  font-size: 11px;
}
</style>