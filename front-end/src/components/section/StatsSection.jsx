const StatsSection = () => {
    const stats = [
      { number: "3.9k+", label: "Perusahaan Terdaftar" },
      { number: "15.8k+", label: "Lowongan Magang" },
      { number: "97.5k+", label: "Magang Selesai dan Sukses" },
      { number: "100.2k+", label: "Siswa/Mahasiswa Terdaftar" },
    ];
  
    return (
      <section className="bg-[#144564] text-white py-10 relative z-[55]">
        <div className="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-center">
          {stats.map((stat, index) => (
            <div key={index}>
              <h3 className="text-3xl font-extrabold">{stat.number}</h3>
              <p className="text-lg">{stat.label}</p>
            </div>
          ))}
        </div>
      </section>
    );
  };
  
  export default StatsSection;
  