import { describe, it, expect, beforeEach } from 'vitest'
import router from '../../router/index.js'

describe('Router Guard', () => {
  beforeEach(async () => {
    localStorage.clear()
    // reset vers une route neutre
    try {
      await router.push('/connexion')
      await router.isReady()
    } catch (e) {
      // ignore
    }
  })

  it('redirige vers /connexion si on va sur une route protégée sans token', async () => {
    await router.push('/accueil')
    await router.isReady()

    expect(router.currentRoute.value.fullPath).toBe('/connexion')
  })

  it('autorise une route protégée si token présent', async () => {
    localStorage.setItem('token', 'FAKE_TOKEN')

    await router.push('/accueil')
    await router.isReady()

    expect(router.currentRoute.value.fullPath).toBe('/accueil')
  })
})
