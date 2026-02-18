import { describe, it, expect, vi, beforeEach } from 'vitest'
import { useProduits } from '../../composables/useProduits'

// mock axios
var getMock

vi.mock('@/api/axios', () => ({
  default: {
    get: (...args) => getMock(...args),
  },
}))

describe('useProduits composable', () => {
  beforeEach(() => {
    getMock = vi.fn()
  })

  it('charge les produits correctement', async () => {
    getMock.mockResolvedValueOnce({
      data: {
        member: [{ id: 1, nom: 'Musc' }],
      },
    })

    const { produits, getProduits } = useProduits()

    await getProduits()

    expect(produits.value.length).toBe(1)
    expect(produits.value[0].nom).toBe('Musc')
  })

  it('gère une erreur API', async () => {
    getMock.mockRejectedValueOnce(new Error('Erreur API'))

    const { error, getProduits } = useProduits()

    await getProduits()

    expect(error.value).toContain('Erreur')
  })
})
