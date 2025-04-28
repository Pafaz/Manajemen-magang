import { createContext } from "react";

export const AuthContext = createContext({
  token: null,
  user: null,
  role: null,
  tempRegisterData: null,
  setToken: () => {},
  setUser: () => {},
  setRole: () => {},
  setTempRegisterData: () => {},
});
