const students = [
    { name: "Gojo Satoru", university: "Harvard University", project: "Pre Mini Project", progress: 32 },
    { name: "Itadori Yuji", university: "Tokyo University", project: "Pre Mini Project", progress: 55 },
    { name: "Nobara Kugisaki", university: "Kyoto University", project: "Pre Mini Project", progress: 68 },
    { name: "Megumi Fushiguro", university: "Keio University", project: "Pre Mini Project", progress: 85 },
    { name: "Maki Zenin", university: "Stanford University", project: "Pre Mini Project", progress: 40 },
    { name: "Toge Inumaki", university: "Oxford University", project: "Pre Mini Project", progress: 25 },
    { name: "Panda", university: "MIT", project: "Pre Mini Project", progress: 78 },
    { name: "Yuta Okkotsu", university: "UCLA", project: "Pre Mini Project", progress: 90 },
    { name: "Kento Nanami", university: "Cambridge University", project: "Pre Mini Project", progress: 61 },
    { name: "Suguru Geto", university: "Columbia University", project: "Pre Mini Project", progress: 73 },
  ];
  
  const AssignmentsTable = () => {
    return (
      <div className="card bg-white shadow mt-6 rounded-xl overflow-hidden border border-[#D5DBE7]">
        <div className="flex justify-between items-center p-4 flex-wrap gap-2">
          <h4 className="text-lg font-semibold">Progres Presentasi</h4>
          <a href="/student-courses.html" className="text-sm text-blue-600 hover:underline">
            See All
          </a>
        </div>
  
        <div className="overflow-x-auto">
          <table className="min-w-full table-fixed text-sm text-left">
            <thead>
              <tr className="border-b border-[#D5DBE7] bg-gray-100">
                <th className="p-4 w-1/3">Nama Siswa</th>
                <th className="p-4 w-1/3 text-center">Project</th>
                <th className="p-4 w-1/3 text-center">Progress</th>
              </tr>
            </thead>
            <tbody>
              {students.map((student, index) => (
                <tr key={index} className="border-b border-[#D5DBE7]">
                  <td className="p-4">
                    <div className="flex items-center gap-3">
                      <div className="w-10 h-10 rounded-full border-4 overflow-hidden" style={{ borderColor: "#0069AB" }}>
                        <img src="/assets/img/post2.png" alt="profil" className="w-full h-full object-cover" />
                      </div>
                      <div>
                        <h6 className="font-medium mb-0">{student.name}</h6>
                        <div className="text-black text-xs flex gap-2">
                          <span>{student.university}</span>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td className="p-4 text-center align-middle">
                    <span className="text-black text-sm font-semibold">{student.project}</span>
                  </td>
                  <td className="p-4 text-center">
                    <div className="flex items-center gap-2 justify-center">
                      <div className="w-24 bg-blue-100 rounded-full h-2">
                        <div
                          className="bg-[#0069AB] h-2 rounded-full"
                          style={{ width: `${student.progress}%` }}
                        ></div>
                      </div>
                      <span className="text-[#0069AB] text-xs font-medium">{student.progress}%</span>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    );
  };
  
  export default AssignmentsTable;
  