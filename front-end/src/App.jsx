import AuthProvider from "../context/AuthProvider";
import { RouterProvider } from "react-router-dom";
import { router } from "../Router";
function App() {
  return (
    <AuthProvider>
      <RouterProvider router={router}/>
    </AuthProvider>
  );
}

export default App;
