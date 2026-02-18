import { describe, it, expect, beforeEach } from 'vitest'
import { setActivePinia, createPinia } from 'pinia'
import { useFavorisStore } from '../../stores/favoris'

describe('Favoris Store', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
    localStorage.clear()
  })

  it('ajoute un favori', () => {
    const store = useFavorisStore()

    const produit = { id: 1, nom: 'Musc Blanc' }

    store.addFavori(produit)

    expect(store.favoris.length).toBe(1)
    expect(store.favoris[0].id).toBe(1)
  })

  it('supprime un favori', () => {
    const store = useFavorisStore()

    store.addFavori({ id: 1 })
    store.removeFavori(1)

    expect(store.favoris.length).toBe(0)
  })
})
