import { useAuthStore } from "@/stores/auth";

export async function apiFetch(url, options = {}) {
  const auth = useAuthStore();

  const headers = {
    ...(options.headers || {}),
    "Content-Type": "application/json",
  };

  if (auth.token) {
    headers.Authorization = `Bearer ${auth.token}`;
  }

  const res = await fetch(url, { ...options, headers });

  // Si token plus bon => logout direct
  if (res.status === 401) {
    auth.logout();
  }

  return res;
}
