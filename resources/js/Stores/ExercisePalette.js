import { defineStore } from 'pinia'
import { ref } from 'vue'

export const exercisePaletteStore = defineStore('exercisePaletteStore', () => {
    const show = ref(false)
    const workout_id = ref(undefined)
    const order = ref(undefined)
    function toggleExercisePalette() {
      show.value = !show.value
    }
    function openExercisePalette(id, o){
      show.value = true
      workout_id.value = id
      order.value = o
    }
    function resetExercisePalette(){
      show.value = false
      workout_id.value = undefined
      order.value = undefined
    }
  
    return { show, workout_id, order, toggleExercisePalette, openExercisePalette, resetExercisePalette }
  })