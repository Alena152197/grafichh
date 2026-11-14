export type ViewMode = 'week' | 'month'

export interface Employee {
  id: number
  full_name: string
  avatar_url: string | null
}

export interface ShiftTemplate {
  id: number
  name: string
  slug: string
  start_time: string
  end_time: string
  duration_hours: number
  color: string
}

export interface Shift {
  id: number
  schedule_id: number
  employee_id: number
  shift_template_id: number | null
  date: string
  start_time: string
  end_time: string
  duration_hours: number
  template?: ShiftTemplate | null
}

export interface CellKey {
  employee_id: number
  date: string
}

export interface Schedule {
  id: number
  title: string
  status: 'draft' | 'published'
}