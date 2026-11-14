import axios from 'axios'
import type { Employee, Shift, ShiftTemplate } from '@/types'

export const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL ?? '/api',
  headers: { Accept: 'application/json' },
})

export const fetchEmployees = (q = '') =>
  api.get<Employee[]>('/employees', { params: { q } }).then((r) => r.data)

export const fetchTemplates = () =>
  api.get<ShiftTemplate[]>('/shift-templates').then((r) => r.data)

export const fetchShifts = (scheduleId: number, from: string, to: string) =>
  api
    .get<Shift[]>(`/schedules/${scheduleId}/shifts`, { params: { from, to } })
    .then((r) => r.data)

export const assignShift = (scheduleId: number, payload: object) =>
  api.post(`/schedules/${scheduleId}/shifts`, payload).then((r) => r.data)

export const bulkAssign = (scheduleId: number, payload: object) =>
  api.post(`/schedules/${scheduleId}/shifts/bulk`, payload).then((r) => r.data)

export const moveShift = (scheduleId: number, payload: object) =>
  api.post(`/schedules/${scheduleId}/shifts/move`, payload).then((r) => r.data)

export const deleteShift = (shiftId: number) => api.delete(`/shifts/${shiftId}`)

export const saveSchedule = (scheduleId: number) =>
  api.post(`/schedules/${scheduleId}/save`).then((r) => r.data)

export const publishSchedule = (scheduleId: number) =>
  api.post(`/schedules/${scheduleId}/publish`).then((r) => r.data)