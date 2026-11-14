<template>
  <button
    class="card"
    type="button"
    draggable="true"
    :style="{ borderLeftColor: accentColor }"
    @click="$emit('select')"
    @dragstart="onDragStart"
  >
    <div class="top">
      <strong>{{ template.name }}</strong>
      <span class="num">{{ index }}</span>
    </div>

    <div class="meta">
      {{ template.start_time.slice(0, 5) }} - {{ template.end_time.slice(0, 5) }}
      · {{ template.duration_hours }} ч
    </div>
  </button>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { ShiftTemplate } from '@/types'

const props = defineProps<{
  template: ShiftTemplate
  index: number
}>()

defineEmits<{ select: [] }>()

const accentMap: Record<string, string> = {
  morning: '#BBC9F7',
  day: '#C8ADFF',
  evening: '#B2EEEB',
}
const accentColor = computed(
  () => accentMap[props.template.slug] ?? '#BBC9F7',
)

function onDragStart(e: DragEvent) {
  e.dataTransfer?.setData(
    'application/json',
    JSON.stringify({ type: 'template', id: props.template.id }),
  )
}
</script>


<style scoped>
.card {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 6px;
  padding: 12px 12px 12px 14px;
  border: 1px solid transparent;
  border-left: 3px solid #BBC9F7;
  border-radius: 12px;
  cursor: grab;
  text-align: left;
}
.card:hover {
  border-color: var(--primary);
}
.top {
  width: 100%;
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 8px;
}
strong {
  font-size: 14px;
  color: var(--text);
}
.num {
  min-width: 24px;
  height: 24px;
  padding: 0 6px;
  border-radius: 8px;
  background: #fff;
  display: grid;
  place-items: center;
  font-size: 12px;
  font-weight: 600;
  color: var(--text);
}
.meta {
  font-size: 12px;
  color: var(--text-muted);
  white-space: nowrap;
}
</style>