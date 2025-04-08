const AlertVerification = () => {
  return (
    <div className="w-full h-14 bg-yellow-50 border border-yellow-500 rounded-lg flex justify-between py-1 px-3 items-center mb-4">
      <h1 className="text-amber-800 font-light text-sm">
        Anda Belum Mengisi Data Diri
      </h1>
      <button className="font-light underline cursor-pointer text-yellow-600 text-sm">
        Verifikasi Data Anda
      </button>
    </div>
  );
};

export default AlertVerification;
