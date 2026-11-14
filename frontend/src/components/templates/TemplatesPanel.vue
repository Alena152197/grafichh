<template>
  <aside class="templates">
    <h3>Шаблоны смен</h3>
    <TemplateCard
      v-for="(t, i) in store.templates"
      :key="t.id"
      :template="t"
      :index="i + 1"
      @select="onSelect(t.id)"
    />
    <CustomShiftForm />
  </aside>
</template>

<script setup lang="ts">
import TemplateCard from './TemplateCard.vue'
import CustomShiftForm from './CustomShiftForm.vue'
import { useScheduleStore } from '@/stores/scheduleStore'

const store = useScheduleStore()

function onSelect(templateId: number) {
  const template = store.templates.find((t) => t.id === templateId)
  if (!template) return

  if (!store.selectedCells.length) {
    alert('Сначала выдели ячейку в таблице')
    return
  }

  void store.applyTemplate(template)
}
</script>

<style scoped>
.templates {
  width: 335px;
  min-height: 740px;
  box-sizing: border-box;
  border-radius: 12px;
  padding: 16px;
  gap: 24px;
  background: #FFFFFF;
  display: flex;
  flex-direction: column;
  border-left: 0;
}
h3 {
  margin: 0;
  width: 114px;
  height: 24px;
  font-weight: 400;
  font-size: 14px;
  line-height: 20px;
  color: #101012;
  display: flex;
  align-items: center;
}
</style>