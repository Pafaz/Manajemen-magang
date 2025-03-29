import { createBrowserRouter } from "react-router-dom";
import GuestLayout from "./src/layout/GuestLayout";
import Index from "./src/pages/Index";
import NotFound from "./src/pages/Error/NotFound";
import About from "./src/pages/About";

export const router = createBrowserRouter([
  {
    path: "/",
    element: <GuestLayout />,
    children: [
      {
        path: "/",
        element: <Index />,
      },
      {
        path:"/about_us",
        element:<About/>
      }
    ],
  },
   {
      path: "*",
      element: <NotFound />,
    },
]);
