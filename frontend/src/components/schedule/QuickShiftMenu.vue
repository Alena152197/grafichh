<template>
  <div class="menu" :style="style" @click.stop>
    <button
      v-for="tpl in templates"
      :key="tpl.id"
      type="button"
      class="item"
      @click="$emit('pick', tpl)"
    >
      <span class="name">{{ tpl.name }}</span>
      <span class="time">
        {{ tpl.start_time.slice(0, 5) }}–{{ tpl.end_time.slice(0, 5) }}
      </span>
    </button>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { ShiftTemplate } from '@/types'

const props = defineProps<{
  templates: ShiftTemplate[]
  x: number
  y: number
}>()

defineEmits<{
  pick: [template: ShiftTemplate]
}>()

const style = computed(() => ({
  left: `${props.x}px`,
  top: `${props.y}px`,
}))
</script>

<style scoped>
.menu {
  position: fixed;
  z-index: 50;
  min-width: 180px;
  padding: 8px;
  border-radius: 12px;
  background: #FFFFFF;
  box-shadow: 0 8px 24px rgba(16, 16, 18, 0.12);
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.item {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 2px;
  width: 100%;
  border: 0;
  border-radius: 8px;
  padding: 8px 10px;
  background: transparent;
  cursor: pointer;
  text-align: left;
}
.item:hover {
  background: #F2F3F7;
}
.name {
  font-size: 14px;
  font-weight: 600;
  color: #101012;
}
.time {
  font-size: 12px;
  color: #737378;
}
</style>