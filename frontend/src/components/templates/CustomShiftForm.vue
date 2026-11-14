<template>
  <div class="custom">
    <h4>Своя смена</h4>

    <div class="times">
      <label>
        Начало
        <input v-model="start" type="time" />
      </label>
      <label>
        Конец
        <input v-model="end" type="time" />
      </label>
    </div>

    <button class="primary" type="button" @click="onAssign">
      <svg class="plus" viewBox="0 0 12 12" width="12" height="12" fill="none">
        <path
          d="M6 1v10M1 6h10"
          stroke="#1C4AE5"
          stroke-width="1.3"
          stroke-linecap="round"
        />
      </svg>
  <span>Поставить в выделенные</span>
    </button>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useScheduleStore } from '@/stores/scheduleStore'

const store = useScheduleStore()
const start = ref('10:00')
const end = ref('18:00')

function hoursBetween(a: string, b: string) {
  const [sh, sm] = a.split(':').map(Number)
  const [eh, em] = b.split(':').map(Number)
  let mins = eh * 60 + em - (sh * 60 + sm)
  if (mins <= 0) mins += 24 * 60
  return Math.round(mins / 60)
}

function onAssign() {
  if (!store.selectedCells.length) {
    alert('Сначала выдели ячейку в таблице')
    return
  }
  void store.applyCustom(start.value, end.value, hoursBetween(start.value, end.value))
}
</script>

<style scoped>
.custom {
  margin-top: 12px;
  padding-top: 12px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}
h4 {
  margin: 0;
  font-size: 14px;
}
label {
  display: flex;
  flex-direction: column;
  gap: 4px;
  font-size: 12px;
  color: var(--text-muted);
}
input {
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 8px 10px;
  color: var(--text);
}
.primary {
  width: 100%;
  max-width: 303px;
  height: 48px;
  box-sizing: border-box;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 4px;
  margin-top: 4px;
  border: 0;
  border-radius: 12px;
  padding: 12px 20px;
  background: #E8EDFC;
  color: #1C4AE5;
  cursor: pointer;
}
.plus {
  flex-shrink: 0;
}
.primary span {
  width: 198px;
  height: 24px;
  font-weight: 600;
  font-size: 14px;
  line-height: 20px;
  text-align: center;
  color: #1C4AE5;
  display: flex;
  align-items: center;
  justify-content: center;
}
.primary:hover {
  background: #D8E2FA;
}
.times {
  display: flex;
  flex-wrap: wrap; /* рядом, при нехватке места — ниже */
  gap: 8px;
}
.times label {
  flex: 1 1 110px; /* тянутся, потом перенос */
  display: flex;
  flex-direction: column;
  gap: 4px;
  font-size: 12px;
  color: var(--text-muted);
}
.times input {
  width: 100%;
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 8px 10px;
}
</style>