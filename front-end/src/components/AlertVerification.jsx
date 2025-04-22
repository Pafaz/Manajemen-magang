import { useEffect, useState } from "react";

const AlertVerification = () => {
  const [isPerusahaan, setIsPerusahaan] = useState(false);

  useEffect(() => {
    // Menentukan apakah user berada di halaman perusahaan atau siswa
    const currentPath = window.location.pathname;
    if (currentPath.includes("perusahaan")) {
      setIsPerusahaan(true);
    } else if (currentPath.includes("student")) {
      setIsPerusahaan(false);
    }
  }, []);

  const handleVerificationClick = () => {
    if (isPerusahaan) {
      // Jika berada di halaman perusahaan, arahkan ke halaman settings perusahaan
      window.location.href = "http://localhost:5173/perusahaan/settings";
    } else {
      // Jika berada di halaman siswa, arahkan ke halaman settings siswa
      window.location.href = "http://localhost:5173/student/settings";
    }
  };

  return (
    <div className="w-full h-14 bg-[#F9A517] border border-[#F9A517] rounded-lg flex justify-between py-1 px-3 items-center mb-4">
      <h1 className="text-black font-semibold text-sm">
        Anda Belum Mengisi Data Diri
      </h1>
      <button
        onClick={handleVerificationClick}
        className="font-semibold text-black text-sm bg-white border border-[#F9A517] rounded-lg py-2 px-4"
      >
        Verifikasi Data Anda
      </button>
    </div>
  );
};

export default AlertVerification;
