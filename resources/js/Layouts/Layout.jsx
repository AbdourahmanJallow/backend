import { UserCircle } from "lucide-react";
import Sidebar, { SidebarItem } from "../components/Sidebar";
import PrivateRoute from "../components/Auth/PrivateRoute";
import React, { useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import { Toaster } from "react-hot-toast";

function Layout({ children }) {
    const [sidebarExpanded, setSidebarExpanded] = useState(false);
    const [activeLink, setActiveLink] = useState("/doctors");
    const auth = usePage().props.auth;

    const handleActiveLink = (path) => {
        setActiveLink(path);
    };

    return (
        <main className="w-full h-screen flex">
            <aside
                className={`hidden sm:flex h-full w-fit fixed ${
                    sidebarExpanded ? "w-fit" : "w-10"
                }`}
            >
                <Sidebar
                    expanded={sidebarExpanded}
                    toggleExpanded={() => setSidebarExpanded(!sidebarExpanded)}
                    user={auth.user}
                >
                    {sidebarLinks.map((link) => (
                        <Link
                            key={link.path}
                            href={link.path}
                            onClick={() => handleActiveLink(link.path)}
                        >
                            <SidebarItem
                                icon={link.icon}
                                text={link.text}
                                active={activeLink === link.path}
                            />
                        </Link>
                    ))}
                </Sidebar>
            </aside>
            <article
                className={`w-full bg-neutral-100 px-5 sm:px-32 sm:py-5 overflow-y-auto h-full transition-all duration-500 ${
                    sidebarExpanded ? "sm:ml-64" : "ml-0"
                }`}
            >
                <PrivateRoute>
                    {React.cloneElement(children, { sidebarExpanded })}
                    <Toaster
                        position="top-center"
                        reverseOrder={true}
                        toastOptions={{ duration: 5000 }}
                    />
                </PrivateRoute>
            </article>
        </main>
    );
}
export default Layout;

const sidebarLinks = [
    {
        path: "/",
        text: "Home",
        icon: (
            <img
                // src="https://cdn-icons-png.flaticon.com/128/1946/1946488.png"
                src="https://cdn-icons-png.flaticon.com/128/2549/2549900.png"
                className="w-6"
            />
        ),
    },
    {
        path: "/doctors",
        text: "Doctors",
        icon: (
            <img
                // src="https://cdn-icons-png.flaticon.com/128/1946/1946488.png"
                src="https://cdn-icons-png.flaticon.com/128/8815/8815112.png"
                className="w-6"
            />
        ),
    },
    {
        path: "/disease-predictor",
        text: "AI Assistant",
        icon: (
            <img
                // src="https://cdn-icons-png.flaticon.com/128/1946/1946488.png"
                src="https://cdn-icons-png.flaticon.com/128/11782/11782353.png"
                className="w-6"
            />
        ),
    },
    {
        path: "/patientsAppointments",
        text: "My Appointments",
        icon: (
            <img
                src="https://cdn-icons-png.flaticon.com/128/4428/4428204.png"
                className="w-8"
            />
        ),
    },
    {
        path: "/patient-profile",
        text: "My Profile",
        icon: <UserCircle size={30} />,
    },
];
