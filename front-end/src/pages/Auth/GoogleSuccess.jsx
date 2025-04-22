import { useEffect } from "react";
import { useNavigate, useSearchParams } from "react-router-dom";

const GoogleSuccess = () => {
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();

  useEffect(() => {
    const token = searchParams.get("token");
    const role = searchParams.get("role");

    if (token) {
      localStorage.setItem("token", token);
      localStorage.setItem("role", role);
      navigate("/dashboard");
    } else {
      alert("Login gagal. Token tidak ditemukan.");
      navigate("/auth/select");
    }
  }, [navigate, searchParams]);

  return <p className="text-center mt-10">Menyelesaikan proses login...</p>;
};

export default GoogleSuccess;
