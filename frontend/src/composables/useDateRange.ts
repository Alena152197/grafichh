import {
  addDays,
  addMonths,
  eachDayOfInterval,
  endOfMonth,
  endOfWeek,
  format,
  startOfMonth,
  startOfWeek,
} from 'date-fns'
import { ru } from 'date-fns/locale'
import type { ViewMode } from '@/types'

export function getRange(anchor: Date, mode: ViewMode) {
  if (mode === 'week') {
    const from = startOfWeek(anchor, { weekStartsOn: 1 })
    const to = endOfWeek(anchor, { weekStartsOn: 1 })
    return { from, to, days: eachDayOfInterval({ start: from, end: to }) }
  }

  const from = startOfMonth(anchor)
  const to = endOfMonth(anchor)
  return { from, to, days: eachDayOfInterval({ start: from, end: to }) }
}

export function shiftAnchor(anchor: Date, mode: ViewMode, dir: -1 | 1) {
  return mode === 'week' ? addDays(anchor, 7 * dir) : addMonths(anchor, dir)
}

export function dayLabel(d: Date, mode: ViewMode) {
  return mode === 'week'
    ? format(d, 'eeeeee d', { locale: ru })
    : format(d, 'd eeeeee', { locale: ru })
}

export function toISODate(d: Date) {
  return format(d, 'yyyy-MM-dd')
}