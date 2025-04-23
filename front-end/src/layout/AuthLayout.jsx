import { useContext, useEffect } from "react";
import { Outlet, useNavigate } from "react-router-dom";
import { AuthContext } from "../contexts/AuthContext";

const AuthLayout = () => {
  const { user } = useContext(AuthContext);
  const navigate = useNavigate();

  useEffect(() => {
    if (user) {
      navigate(localStorage.getItem("location"));
    }
  }, [user, navigate]);

  return <Outlet />;
};

export default AuthLayout;
