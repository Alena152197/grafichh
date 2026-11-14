<template>
  <div class="toolbar">
    <label class="search">
      <svg class="icon" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8">
        <circle cx="11" cy="11" r="7" />
        <path d="M20 20l-3.5-3.5" />
      </svg>
      <input
        type="search"
        placeholder="Поиск по ФИО"
        :value="search"
        @input="$emit('update:search', ($event.target as HTMLInputElement).value)"
      />
    </label>

    <div class="modes">
      <button
        type="button"
        :class="{ active: viewMode === 'month' }"
        @click="$emit('update:viewMode', 'month')"
      >
        Месяц
      </button>
      <button
        type="button"
        :class="{ active: viewMode === 'week' }"
        @click="$emit('update:viewMode', 'week')"
      >
        Неделя
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { ViewMode } from '@/types'

defineProps<{
  search: string
  viewMode: ViewMode
}>()

defineEmits<{
  'update:search': [value: string]
  'update:viewMode': [value: ViewMode]
}>()
</script>

<style scoped>
.toolbar {
  display: flex;
  align-items: center;
  gap: 8px;
  height: 48px;
}
.search {
  display: flex;
  align-items: center;
  gap: 10px;
  width: 398px;
  height: 48px;
  padding: 12px;
  border-radius: 12px;
  background: #F2F3F7;
  box-sizing: border-box;
}
.icon {
  flex-shrink: 0;
  color: #737378;
}
.search input {
  flex: 1;
  border: 0;
  outline: none;
  background: transparent;
  font-size: 14px;
  line-height: 24px;
  color: #101012;
}
.search input::placeholder {
  color: #737378;
}
.modes {
  display: flex;
  align-items: center;
  gap: 8px;
}
.modes button {
  width: 148.5px;
  height: 44px;
  border: 0;
  border-radius: 10px;
  padding: 8px 24px;
  background: #F2F3F7;
  color: #101012;
  font-weight: 600;
  font-size: 14px;
  line-height: 20px;
  cursor: pointer;
}
.modes button.active {
  background: #3C3C43;
  color: #FFFFFF;
}
</style>