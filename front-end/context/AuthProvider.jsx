import PropTypes from "prop-types";
import { useEffect, useState } from "react";
import axios from "axios";
import { AuthContext } from "./AuthContext";

export default function AuthProvider({ children }) {
  const [token, setToken] = useState(localStorage.getItem("token"));
  const [user, setUser] = useState(null);
  const [errors, setErrors] = useState(null);

  const getDataUser = () => {
    if (!token) return;
    try {
      const response = axios.get("/api/getUser", {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });

      const data = response.data;
      if (response.status === 200) {
        setUser(data);
      } else {
        localStorage.removeItem("token");
        setUser(null);
        setToken(null);
        setErrors(data.errors || { error: data.error });
      }
    } catch (error) {
      console.log(error);
    }
  };

  useEffect(() => {
    if (token) {
      getDataUser();
      localStorage.setItem("token", token);
    } else {
      localStorage.removeItem("token");
    }
  }, [token]);

  return (
    <AuthContext.Provider value={{ setToken, setUser, user, token, errors }}>
      {children}
    </AuthContext.Provider>
  );
}

AuthProvider.propTypes = {
  children: PropTypes.node.isRequired,
};
