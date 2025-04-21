import axios from "axios";
import { useEffect } from "react";
import { useState } from "react";

export default function AuthProvider({ children }) {
  const [token, setToken] = useState(localStorage.getItem("token"));
  const [user, setUser] = useState(null);
  const [errors, setErrors] = useState(null);

  const getUser = async () => {
    if (!token) return;

    try {
      const response = await axios.get("http://127.0.0.1:8000/api/get-user", {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      const data = response.user;
      console.log(data);
      if (data.status === 200) {
        setUser(data.user);
      } else {
        setToken(null);
        setUser(null);
        localStorage.removeItem("token");
        setErrors(data.errors || { error: data.error });
      }
    } catch (error) {
      console.log(error);
    }
  };

  useEffect(() => {
    if (token) {
      getUser();
      localStorage.setItem("token", token);
    } else {
      localStorage.removeItem("token");
    }
  }, [token]);

  return (
    <AuthContext.Provider value={{ token, setToken, user, setUser, errors }}>
      {children}
    </AuthContext.Provider>
  );
}
