<template>
  <div class="bar">
    <div class="left">
      <span class="label">Выделено:</span>
      <span class="badge">{{ cellsCount }}</span>
      <span class="meta">{{ employeesCount }} сотрудник(ов)</span>
      <span class="meta">{{ daysCount }} дн.</span>
    </div>
    <div class="right">
      <button class="action" type="button" @click="$emit('apply')">
        <svg viewBox="0 0 16 16" width="16" height="16" fill="none">
          <rect x="2.5" y="2.5" width="11" height="11" rx="2" stroke="#FFFFFF" stroke-width="0.87" />
          <path d="M5 8h6M8 5v6" stroke="#FFFFFF" stroke-width="0.87" stroke-linecap="round" />
        </svg>
        <span>Применить шаблон</span>
      </button>
      <button class="action" type="button" @click="$emit('clear')">
        <svg viewBox="0 0 16 16" width="16" height="16" fill="none">
          <path
            d="M3 4h10M6 4V3h4v1M5 4l.5 9h5L11 4"
            stroke="#FFFFFF"
            stroke-width="0.87"
            stroke-linecap="round"
            stroke-linejoin="round"
          />
        </svg>
        <span>Очистить</span>
      </button>
      <button class="action" type="button" @click="$emit('deselect')">
        <svg viewBox="0 0 16 16" width="16" height="16" fill="none">
          <path d="M4 4l8 8M12 4l-8 8" stroke="#FFFFFF" stroke-width="0.87" stroke-linecap="round" />
        </svg>
        <span>Снять</span>
      </button>
    </div>
  </div>
</template>
<script setup lang="ts">
defineProps<{
  cellsCount: number
  employeesCount: number
  daysCount: number
}>()
defineEmits<{
  apply: []
  clear: []
  deselect: []
}>()
</script>
<style scoped>
.bar {
  width: 100%;
  max-width: 993px;
  height: 52px;
  box-sizing: border-box;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  border-radius: 12px;
  padding: 8px 12px;
  background: #3C3C43;
  color: #FFFFFF;
}
.left,
.right {
  display: flex;
  align-items: center;
  gap: 8px;
}
.label,
.meta,
.action span {
  font-weight: 400;
  font-size: 12px;
  line-height: 16px;
  color: #FFFFFF;
}
.badge {
  min-width: 66px;
  height: 24px;
  box-sizing: border-box;
  border-radius: 99px;
  padding: 2px 8px;
  background: #595961;
  display: grid;
  place-items: center;
  font-size: 12px;
  color: #FFFFFF;
}
.action {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border: 0;
  background: transparent;
  color: #FFFFFF;
  cursor: pointer;
  padding: 0;
}
</style>