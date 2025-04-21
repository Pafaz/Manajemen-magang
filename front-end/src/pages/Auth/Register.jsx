import { useParams, useNavigate } from "react-router-dom";
import { useEffect, useState } from "react";
import FloatingLabelInput from "../../components/FloatingLabelInput";
import { motion } from "framer-motion";
import axios from "axios";

const Register = () => {
  const { type } = useParams();
  const navigate = useNavigate();
  const [role, setRole] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState({});
  const [termsChecked, setTermsChecked] = useState(false);

  const allowedTypes = {
    a1b2c3d4: "company",
    x9y8z7w6: "student",
  };

  useEffect(() => {
    if (!allowedTypes[type]) {
      navigate("/auth/select");
    } else {
      setRole(allowedTypes[type]);
    }
  }, [type, navigate]);

  const getTitle = () => {
    if (role === "company") return "Selamat Datang, Calon Mitra Perusahaan 👋";
    if (role === "student") return "Selamat Datang, Calon Siswa Magang 👋";
    return "";
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setErrors({});

    if (password !== confirmPassword) {
      setErrors({ password_confirmation: ["Kata sandi dan konfirmasi kata sandi tidak cocok."] });
      setLoading(false);
      return;
    }

    const data = {
      email,
      password,
      password_confirmation: confirmPassword,
    };

    try {
      const url =
        role === "company" ? "register-perusahaan" : "register-peserta";

      const response = await axios.post(
        `http://127.0.0.1:8000/api/${url}`,
        data,
        {
          headers: {
            "Content-Type": "application/json",
          },
        }
      );

      if (response.data.status === "success") {
        navigate("/auth/success");
      } else {
        if (response.data.meta && response.data.meta.email) {
          setErrors({ email: response.data.meta.email });
        } else {
          setErrors(response.data.errors || { message: response.data.message });
        }
      }
    } catch (err) {
      if (err.response) {
        if (err.response.data.meta && err.response.data.meta.email) {
          setErrors({ email: err.response.data.meta.email });
        } else {
          setErrors(
            err.response.data.errors || {
              message: "Terjadi kesalahan. Silakan coba lagi.",
            }
          );
        }
      } else {
        console.log("Error general:", err);
        setErrors({ message: "Terjadi kesalahan. Silakan coba lagi." });
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="w-full h-screen bg-white relative p-8 overflow-hidden">
      <motion.div
        initial={{ opacity: 0, y: -50 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.6, ease: "easeOut" }}
        className="flex justify-start"
      >
        <img src="/assets/img/Logo.png" alt="Logo" className="w-52" />
      </motion.div>

      <motion.div
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        transition={{ duration: 1 }}
        className="absolute left-0 top-0 z-10"
      >
        <img src="/assets/Auth/Shape_blue.png" alt="ShapeBlue" />
      </motion.div>

      <motion.div
        initial={{ scale: 0.8, opacity: 0 }}
        animate={{ scale: 1, opacity: 1 }}
        transition={{ duration: 0.7, delay: 0.3 }}
        className="absolute left-0 top-30 z-20"
      >
        <img
          src="/assets/Auth/ilustrationAuth.png"
          alt="Ilustrasi Auth"
          className="w-xl"
        />
      </motion.div>

      <motion.div
        initial={{ x: 100, opacity: 0 }}
        animate={{ x: 0, opacity: 1 }}
        transition={{ duration: 0.7, delay: 0.4 }}
        className="w-full max-w-sm absolute z-50 right-55 top-30"
      >
        <div className="space-y-5">
          <h1 className="text-3xl font-bold text-gray-800">{getTitle()}</h1>
          <p className="text-gray-500 text-sm mb-5">
            Silakan isi data berikut untuk membuat akun{" "}
            {role === "company" ? "perusahaan" : "siswa"}.
          </p>
        </div>

        <form onSubmit={handleSubmit}>
          <FloatingLabelInput
            label="Email"
            type="email"
            value={email}
            setValue={setEmail}
            placeholder="Masukkan alamat email kamu"
            icon="bi-envelope"
          />
          {errors.email && (
            <p className="text-red-500 text-xs my-1 mb-2">{errors.email[0]}</p>
          )}

          <FloatingLabelInput
            label="Kata Sandi"
            type="password"
            value={password}
            setValue={setPassword}
            placeholder="Masukkan kata sandi"
            icon="bi-lock"
          />
          {errors.password && (
            <p className="text-red-500 text-xs my-1 mb-2">
              {errors.password[0]}
            </p>
          )}

          <FloatingLabelInput
            label="Konfirmasi Kata Sandi"
            type="password"
            value={confirmPassword}
            setValue={setConfirmPassword}
            placeholder="Ulangi kata sandi"
            icon="bi-lock"
          />
          {errors.password_confirmation && (
            <p className="text-red-500 text-xs my-1 mb-2">
              {errors.password_confirmation[0]}
            </p>
          )}

          {errors.message && (
            <p className="text-red-500 text-xs my-1 mb-2">{errors.message}</p>
          )}

          <div className="flex items-center mt-4">
            <input
              type="checkbox"
              id="terms"
              checked={termsChecked}
              onChange={() => setTermsChecked(!termsChecked)}
              className="mr-2"
            />
            <label htmlFor="terms" className="text-gray-500 text-xs">
              Saya setuju dengan{" "}
              <a href="/terms" className="text-blue-500">
                Terms of Service
              </a>{" "}
              dan{" "}
              <a href="/privacy" className="text-blue-500">
                Privacy Policy
              </a>
            </label>
          </div>

          <button
            type="submit"
            className={`w-full mt-4 p-3 bg-blue-500 text-white rounded-lg font-bold hover:bg-blue-600 ${
              loading || !termsChecked ? "opacity-50 cursor-not-allowed" : ""
            }`}
            disabled={loading || !termsChecked}
          >
            {loading ? "Mendaftar..." : "Daftar"}
          </button>
        </form>

        <div className="flex items-center my-4">
          <div className="flex-1 border-t border-gray-300"></div>
          <p className="mx-4 text-gray-500">Atau daftar dengan</p>
          <div className="flex-1 border-t border-gray-300"></div>
        </div>

        <div className="flex justify-center gap-4">
          <button className="w-full border border-blue-500 py-2.5 rounded-sm hover:bg-sky-50 hover:border-blue-500 cursor-pointer hover:scale-105 transition-all duration-300 ease-in-out flex gap-2 justify-center">
            <img
              src="/assets/Auth/Google.png"
              alt="Google"
              className="w-6 h-6"
            />
          </button>
        </div>
      </motion.div>
    </div>
  );
};

export default Register;
