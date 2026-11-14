import { computed, type Ref } from 'vue'
import type { Shift } from '@/types'

export function useCoverage(shifts: Ref<Shift[]>, daysISO: Ref<string[]>) {
  return computed(() => {
    const map: Record<string, number> = {}
    for (const day of daysISO.value) map[day] = 0
    for (const s of shifts.value) {
      if (map[s.date] !== undefined) map[s.date] += 1
    }
    return map
  })
}