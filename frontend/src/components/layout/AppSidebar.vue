<template>
<aside class="sidebar">
  <div class="top">
  <div class="logo">CRM</div>
  <button class="bell" type="button" aria-label="Уведомления">
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
      <path d="M6 9a6 6 0 0 1 12 0c0 7 3 7 3 9H3c0-2 3-2 3-9" />
      <path d="M10 20a2 2 0 0 0 4 0" />
    </svg>
  </button>
  </div>
  <nav>
    <a class="link" href="#">
      <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
        <path d="M3 10.5 12 3l9 7.5" />
        <path d="M5 10v10h14V10" />
      </svg>
      <span>Главная</span>
    </a>
    <a class="link active" href="#">
      <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
        <rect x="3" y="5" width="18" height="16" rx="2" />
        <path d="M3 9h18M8 3v4M16 3v4" />
      </svg>
      <span>Смены</span>
    </a>
  </nav>
  <button class="collapse" type="button">
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
      <rect x="3" y="4" width="18" height="16" rx="2" />
      <path d="M9 4v16" />
    </svg>
    <span>Свернуть меню</span>
  </button>
</aside>
</template>

<script setup lang="ts">
</script>

<style scoped>
.sidebar {
  width: var(--sidebar-w);
  min-height: 100vh;
  background: #F2F3F7;
  color: #101012;
  padding: 16px 16px 16px 14px;
  display: flex;
  flex-direction: column;
  gap: 24px;
  border-right: 1px solid #e6e8ee;
  box-sizing: border-box;
}
.top {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.logo {
  width: 45px;
  height: 24px;
  font-weight: 600;
  font-size: 16px;
  line-height: 24px;
  letter-spacing: 0;
  color: #000000;
  display: flex;
  align-items: center;
}
.bell {
  width: 32px;
  height: 32px;
  border: 0;
  border-radius: 8px;
  background: transparent;
  color: #101012;
  cursor: pointer;
  display: grid;
  place-items: center;
}
.bell:hover {
  background: #e5e7eb;
}
nav {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.link,
.collapse {
  display: flex;
  align-items: center;
  gap: 10px;
  width: 100%;
  color: #101012;
  text-decoration: none;
  font-size: 14px;
  font-weight: 600;
  line-height: 20px;
  padding: 10px 8px;
  border-radius: 8px;
  background: transparent;
  border: 0;
  cursor: pointer;
  text-align: left;
}
.link span,
.collapse span {
  color: #101012;
}
.link.active {
  background: #ffffff;
  color: #101012;
}
.collapse {
  margin-top: auto;
  color: #6b7280;
}
.collapse span {
  color: #6b7280;
}
</style>