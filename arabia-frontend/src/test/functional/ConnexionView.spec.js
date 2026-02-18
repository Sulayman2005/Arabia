import { describe, it, expect, vi, beforeEach } from 'vitest'
import { mount } from '@vue/test-utils'
import { createPinia, setActivePinia } from 'pinia'
import ConnexionView from '../../views/ConnexionView.vue'
import { useAuthStore } from '../../stores/auth'

const flushPromises = () => new Promise((resolve) => setTimeout(resolve, 0))

// ---- Mock router ----
const pushMock = vi.fn()
vi.mock('vue-router', async () => {
  const actual = await vi.importActual('vue-router')
  return {
    ...actual,
    useRouter: () => ({ push: pushMock }),
  }
})

// ✅ IMPORTANT : var pour éviter le problème de hoisting
var postMock

vi.mock('@/api/axios', () => ({
  default: {
    post: (...args) => postMock(...args),
  },
}))

describe('ConnexionView', () => {
  beforeEach(() => {
    vi.clearAllMocks()
    localStorage.clear()
    setActivePinia(createPinia())

    // initialise postMock à chaque test
    postMock = vi.fn()
  })

  it('affiche une erreur si email ou mot de passe vide', async () => {
    const wrapper = mount(ConnexionView)

    await wrapper.find('form').trigger('submit.prevent')
    await flushPromises()
    await wrapper.vm.$nextTick()

    expect(wrapper.text()).toContain('Veuillez renseigner votre email et votre mot de passe.')
    expect(postMock).not.toHaveBeenCalled()
    expect(pushMock).not.toHaveBeenCalled()
  })

  it('login OK : appelle API, setAuth, puis redirige vers /accueil', async () => {
    postMock.mockResolvedValueOnce({ data: { token: 'FAKE_JWT_TOKEN' } })

    const wrapper = mount(ConnexionView)

    const inputs = wrapper.findAll('input')
    await inputs[0].setValue('admin@test.com')
    await inputs[1].setValue('password')

    const authStore = useAuthStore()
    const setAuthSpy = vi.spyOn(authStore, 'setAuth')

    await wrapper.find('form').trigger('submit.prevent')
    await flushPromises()
    await wrapper.vm.$nextTick()

    expect(postMock).toHaveBeenCalledWith('/login', {
      email: 'admin@test.com',
      password: 'password',
    })

    expect(setAuthSpy).toHaveBeenCalledWith('FAKE_JWT_TOKEN')
    expect(pushMock).toHaveBeenCalledWith('/accueil')
  })

  it('login KO : affiche "Identifiants incorrects"', async () => {
    postMock.mockRejectedValueOnce(new Error('401'))

    const wrapper = mount(ConnexionView)

    const inputs = wrapper.findAll('input')
    await inputs[0].setValue('admin@test.com')
    await inputs[1].setValue('badpassword')

    const authStore = useAuthStore()
    const setAuthSpy = vi.spyOn(authStore, 'setAuth')

    await wrapper.find('form').trigger('submit.prevent')
    await flushPromises()
    await wrapper.vm.$nextTick()

    expect(wrapper.text()).toContain('Identifiants incorrects')
    expect(setAuthSpy).not.toHaveBeenCalled()
    expect(pushMock).not.toHaveBeenCalled()
  })
})
