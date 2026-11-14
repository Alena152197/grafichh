<template>
  <header class="header">
    <div class="crumb">
      <button class="back" type="button" aria-label="Назад">‹</button>
      <span>Графики смен</span>
    </div>
    <div class="title-row">
      <h1>График</h1>
      <div class="actions">
        <button class="outline" type="button" @click="$emit('publish')">
          Опубликовать
        </button>
        <button class="solid" type="button" @click="$emit('save')">
          Сохранить
        </button>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
defineEmits<{ save: []; publish: [] }>()
</script>

<style scoped>
.header {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.crumb {
  display: flex;
  align-items: center;
  gap: 12px;
  height: 40px;
}
.crumb span {
  width: 106px;
  height: 22px;
  font-weight: 400;
  font-size: 14px;
  line-height: 140%;
  letter-spacing: 0;
  color: #101012;
  display: flex;
  align-items: center;
}
.back {
  width: 40px;
  height: 40px;
  border-radius: 99px;
  padding: 8px;
  border: 1px solid var(--border);
  background: #fff;
  cursor: pointer;
  display: grid;
  place-items: center;
  color: #101012;
  font-size: 20px;
  line-height: 1;
  box-sizing: border-box;
}
.title-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 48px;
  gap: 16px;
}
h1 {
  margin: 0;
  width: 106px;
  height: 32px;
  font-weight: 500;
  font-size: 24px;
  line-height: 32px;
  color: #101012;
  display: flex;
  align-items: center;
}
.actions {
  display: flex;
  align-items: center;
  gap: 8px;
}
.outline,
.solid {
  height: 48px;
  border-radius: 12px;
  padding: 12px 20px;
  border: 0;
  cursor: pointer;
  font-weight: 600;
  font-size: 14px;
  line-height: 20px;
  text-align: center;
  box-sizing: border-box;
}
.outline {
  width: 144px;
  background: #E8EDFC;
  color: #1C4AE5;
}
.solid {
  width: 118px;
  background: #5B7DEC;
  color: #FFFFFF;
}
</style>