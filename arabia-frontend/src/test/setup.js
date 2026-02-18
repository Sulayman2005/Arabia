import { vi } from 'vitest'

// Exemple : mock global pour console.error
vi.stubGlobal('console', { ...console, error: vi.fn() })
