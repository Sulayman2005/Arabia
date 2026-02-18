import { describe, it, expect, vi, beforeEach } from 'vitest'
import { mount } from '@vue/test-utils'
import { createPinia, setActivePinia } from 'pinia'
import HomeView from '../../views/HomeView.vue'
import { useFavorisStore } from '../../stores/favoris'

var getMock

vi.mock('@/api/axios', () => ({
  default: {
    get: (...args) => getMock(...args),
    delete: vi.fn(),
  },
}))

describe('HomeView', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
    localStorage.clear()

    getMock = vi.fn().mockResolvedValue({
      data: {
        member: [{ id: 1, nom: 'Musc', image: 'test.jpg' }],
      },
    })
  })

  const mountComponent = () =>
    mount(HomeView, {
      global: {
        stubs: {
          RouterLink: {
            template: '<a><slot /></a>',
          },
        },
      },
    })

  it('affiche les produits après chargement', async () => {
    const wrapper = mountComponent()

    await new Promise(r => setTimeout(r, 0))
    await wrapper.vm.$nextTick()

    expect(wrapper.html()).toContain('Ajoutez aux favoris')
  })

  it('ajoute un produit aux favoris au clic', async () => {
    const wrapper = mountComponent()

    await new Promise(r => setTimeout(r, 0))
    await wrapper.vm.$nextTick()

    const button = wrapper.find('button')
    expect(button.exists()).toBe(true)

    await button.trigger('click')

    const store = useFavorisStore()
    expect(store.favoris.length).toBe(1)
  })
})
