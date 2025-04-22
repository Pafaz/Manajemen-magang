import coverImage from '/assets/img/Cover.png';
import logoImage from '/assets/img/logoperusahaan.png';
import React, { useState } from "react";

export default function CompanyCard() {
  const [companyName, setCompanyName] = useState("PT. Humma Technology Indonesia");
  const [description, setDescription] = useState(
    "Perusahaan ini bergerak di bidang Informasi dan Teknologi untuk perkembangan Industri"
  );
  const [location, setLocation] = useState("Malang, Indonesia");

  return (
    <div className="bg-white rounded-lg shadow-lg overflow-hidden w-full max-w-4xl mx-auto">
      <img
      src={coverImage}
      alt="Cover"
      className="w-full h-60 object-cover"
      />
      <div className="flex items-center justify-between px-6 py-4">
        <div className="flex items-start gap-4">
          <img
            src="/assets/img/logoperusahaan.png"
            alt="Logo"
            className="w-12 h-12"
          />
          <div>
            <h2 className="text-xl font-bold text-gray-800">{companyName}</h2>
            <p className="text-sm text-gray-600">{description}</p>
            <div className="flex items-center gap-2 text-sm text-gray-500 mt-1">
              <svg className="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2C6.13 2 3 5.13 3 9c0 5.25 7 11 7 11s7-5.75 7-11c0-3.87-3.13-7-7-7z" />
              </svg>
              <span>{location}</span>
            </div>
          </div>
        </div>
        <button className="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700">
          Tambah Cabang
        </button>
      </div>
    </div>
  );
}