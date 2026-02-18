import { describe, it, expect, beforeEach } from 'vitest'
import { mount } from '@vue/test-utils'
import { createPinia, setActivePinia } from 'pinia'
import FavorisView from '../../views/FavorisView.vue'
import { useFavorisStore } from '../../stores/favoris'

describe('FavorisView', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
    localStorage.clear()
  })

  it('affiche message si aucun favori', () => {
    const wrapper = mount(FavorisView)

    expect(wrapper.text()).toContain('Aucun favori pour le moment')
  })

  it('affiche les favoris présents', () => {
    const store = useFavorisStore()
    store.addFavori({ id: 1, nom: 'Musc', image: 'test.jpg' })

    const wrapper = mount(FavorisView)

    expect(wrapper.text()).toContain('Retirer des favoris')
  })
})
