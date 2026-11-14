<template>
  <div class="coverage-row">
    <div class="label">Покрытие</div>
    <div
      class="cells"
      :style="{
      gridTemplateColumns: `repeat(${dates.length}, ${dayCol})`,
    }"
    >
      <div
        v-for="day in dates"
        :key="day"
        class="cell"
        :class="(coverage[day] ?? 0) > 0 ? 'ok' : 'empty'"
      >
        <span class="value">{{ coverage[day] ?? 0 }}</span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  dates: string[]
  coverage: Record<string, number>
  dayCol: string
}>()
</script>

<style scoped>
.coverage-row {
  display: grid;
  grid-template-columns: 220px max-content;
  align-items: stretch;
  width: max-content;
}
.label {
  position: sticky;
  left: 0;
  z-index: 2;
  background: #FFFFFF;
  width: 220px;
  display: flex;
  align-items: center;
  padding: 8px 12px;
  color: var(--text-muted);
  font-size: 13px;
  box-sizing: border-box;
}
.cells {
  display: grid;
  gap: 0;
}
.cell {
  width: 100%;
  min-width: 0;
  min-height: 56px;
  display: grid;
  place-items: center;
  box-sizing: border-box;
}
.value {
  font-weight: 600;
  font-size: 13px;
}
.cell.ok {
  background: var(--coverage-ok);
}
.cell.ok .value {
  color: #1d4ed8;
}
.cell.empty {
  background: var(--coverage-empty);
}
.cell.empty .value {
  color: #be123c;
}
</style>