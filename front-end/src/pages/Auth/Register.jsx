import { useNavigate } from "react-router-dom";
import { useContext, useState } from "react";
import FloatingLabelInput from "../../components/FloatingLabelInput";
import { motion } from "framer-motion";
import { AuthContext } from "../../contexts/AuthContext";

const Register = () => {
  const navigate = useNavigate();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState({});
  const [termsChecked, setTermsChecked] = useState(false);
  const { setTempRegisterData } = useContext(AuthContext);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setErrors({});

    let validationErrors = {};

    if (!email) {
      validationErrors.email = ["Email harus diisi."];
    }

    if (!password) {
      validationErrors.password = ["Kata sandi harus diisi."];
    }

    if (!confirmPassword) {
      validationErrors.password_confirmation = [
        "Konfirmasi kata sandi harus diisi.",
      ];
    }

    if (password !== confirmPassword) {
      validationErrors.password_confirmation = [
        "Kata sandi dan konfirmasi kata sandi tidak cocok.",
      ];
    }

    if (!termsChecked) {
      validationErrors.terms = ["Anda harus menyetujui syarat dan ketentuan."];
    }

    if (Object.keys(validationErrors).length > 0) {
      setErrors(validationErrors);
      setLoading(false);
      return;
    }

    const data = {
      email,
      password,
      password_confirmation: confirmPassword,
    };

    setTempRegisterData(data);
    navigate("/auth/SelectAuth");
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
        className="w-full max-w-sm absolute z-50 right-50 top-40"
      >
        <div className="space-y-5">
          <h1 className="text-3xl font-bold text-gray-800">
          Selamat Datang, Lengkapi Data Anda untuk Memulai 🚀
          </h1>
          <p className="text-gray-500 text-sm mb-5">
            Untuk melanjutkan proses pendaftaran, silakan lengkapi informasi
            berikut dengan benar.
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
          {errors.terms && (
            <p className="text-red-500 text-xs my-1 mb-2">{errors.terms[0]}</p>
          )}

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
      </motion.div>
    </div>
  );
};

export default Register;
