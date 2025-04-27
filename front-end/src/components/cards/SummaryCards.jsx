import React from 'react';

const SummaryCards = () => {
  const summaryData = [
    {
      title: 'Jumlah Admin',
      count: 20,
      unit: 'Orang',
      icon: 'bi bi-person-circle',
      bgColor: 'bg-blue-600'
    },
    {
      title: 'Jumlah Peserta Magang',
      count: 120,
      unit: 'Orang',
      icon: 'bi bi-people',
      bgColor: 'bg-orange-400'
    },
    {
      title: 'Jumlah Mentor',
      count: 15,
      unit: 'Orang',
      icon: 'bi bi-person-check',
      bgColor: 'bg-red-400'
    },
    {
      title: 'Jumlah Divisi',
      count: 6,
      unit: 'Divisi',
      icon: 'bi bi-collection',
      bgColor: 'bg-green-500'
    }
  ];

  return (
    <div className="p-0">
      <div className="bg-white-200 pr-8 pl-0 pt-8 pb-8"> {/* Menghapus padding kiri, menjaga padding kanan, atas, dan bawah */}
        <div className="grid grid-cols-2 gap-6">
          {summaryData.map((item, index) => (
            <div
              key={index}
              className="bg-white-100 rounded-2xl shadow-md p-2 transition-all duration-300 hover:shadow-xl hover:scale-105 cursor-pointer"
            >
              <div className="flex flex-col h-33"> {/* Ubah tinggi card */}
                <h3 className="text-sm font-semibold text-gray-800 mb-auto">{item.title}</h3>
                <div className="flex items-center justify-between">
                  <span className="text-sm font-bold text-gray-900">
                    {item.count} {item.unit}
                  </span>
                  <div className={`${item.bgColor} rounded-full flex items-center justify-center w-14 h-14`}>
                    <i className={`${item.icon} text-3xl text-white`}></i>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default SummaryCards;
