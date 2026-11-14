# График смен сотрудников

Приложение для создания и редактирования рабочего графика сотрудников.

**Стек:** Vue 3, TypeScript, Vite, Laravel, SQLite.

## Возможности

- просмотр графика по неделе и месяцу;
- поиск сотрудников по ФИО;
- назначение смен из шаблонов «Утро», «День», «Вечер»;
- быстрый выбор смены по клику на дату;
- создание своей смены с произвольным временем;
- перетаскивание шаблонов и смен между ячейками;
- индикатор покрытия по датам;
- сохранение и публикация графика.

## Запуск

### 1. Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Откроется API: [http://localhost:8000](http://localhost:8000)

### 2. Frontend

В файле `frontend/.env`:

```
VITE_API_URL=http://localhost:8000/api
```

Затем:

```bash
cd frontend
npm install
npm run dev
```

Откроется приложение: [http://localhost:5173](http://localhost:5173)

## Структура

- `backend/` — Laravel API
- `frontend/` — Vue-приложение
