import { useState } from 'react';

export default function AdminModal() {
  const [isOpen, setIsOpen] = useState(true);

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
      <div className="bg-white rounded-lg shadow-lg w-full max-w-md overflow-hidden">
        <div className="bg-orange-400 p-4 text-gray-700 text-sm font-medium">
          detail admin
        </div>
        
        <div className="p-6 flex flex-col items-center">
          <div className="bg-gray-600 rounded-lg overflow-hidden w-32 h-32 mb-4">
            <img 
              src="/api/placeholder/256/256" 
              alt="Admin Profile" 
              className="w-full h-full object-cover"
            />
          </div>
          
          <h2 className="text-3xl font-bold mt-2 mb-1">Tomori Nao</h2>
          <p className="text-blue-500 text-lg mb-4">Admin Cabang A</p>
          
          <div className="w-full text-center text-gray-600">
            <p className="mb-2">ini@gmail.com</p>
            <p>08881920312</p>
          </div>
        </div>
      </div>
    </div>
  );
}