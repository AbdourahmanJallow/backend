import { router } from "@inertiajs/react";
import {
    MoreVertical,
    ChevronLast,
    ChevronFirst,
    LogOut,
    LucideLogOut,
} from "lucide-react";
import { useContext, createContext, useState } from "react";

const SidebarContext = createContext();

export default function Sidebar({ children, expanded, toggleExpanded, user }) {
    const handleLogout = () => {
        try {
            router.post(
                "/patient/logout",
                {},
                {
                    onSuccess: () => {
                        // router.visit("/login-patient");
                    },
                }
            );
        } catch (error) {
            console.log(error.message);
        }
    };

    return (
        <aside className="h-screen">
            <nav className="h-full flex flex-col bg-white border-r shadow-sm">
                <div className="p-4 pb-2 flex justify-between items-center">
                    <img
                        src="https://img.logoipsum.com/225.svg"
                        className={`overflow-hidden transition-all duration-500 h-10 ${
                            expanded ? "w-10" : "w-0"
                        }`}
                        alt=""
                    />
                    <button
                        onClick={toggleExpanded}
                        className="p-1.5 rounded-lg bg-gray-50 hover:bg-gray-100"
                    >
                        {expanded ? <ChevronFirst /> : <ChevronLast />}
                    </button>
                </div>

                <SidebarContext.Provider value={{ expanded }}>
                    <ul className="flex-1 px-3 mt-5">{children}</ul>
                </SidebarContext.Provider>

                <div className="border-t flex p-3">
                    <img
                        src="https://ui-avatars.com/api/?background=bbf7d0&color=3730a3&bold=true"
                        alt=""
                        className="w-10 h-10 rounded-md"
                    />
                    <div
                        className={`
              flex justify-between items-center
              overflow-hidden transition-all ${expanded ? "w-52 ml-3" : "w-0"}
          `}
                    >
                        <div className="leading-4">
                            <h4 className="font-semibold">{user.name}</h4>
                            <span className="text-xs text-gray-600">
                                {user.email}
                            </span>
                        </div>
                        <button onClick={handleLogout} className="rounded">
                            <LucideLogOut size={20} />
                        </button>
                    </div>
                </div>
            </nav>
        </aside>
    );
}

export function SidebarItem({ icon, text, active, alert }) {
    const { expanded } = useContext(SidebarContext);

    return (
        <li
            className={`
        mb-5 relative flex items-center py-2 px-3 my-1
        font-medium rounded-md cursor-pointer
        transition-colors group
        ${
            active
                ? "bg-gradient-to-tr from-green-400 to-green-300 text-green-800"
                : "hover:bg-green-100 text-gray-600"
        }
    `}
        >
            {icon}
            <span
                className={`overflow-hidden transition-all ${
                    expanded ? "w-52 ml-3" : "w-0"
                }`}
            >
                {text}
            </span>
            {alert && (
                <div
                    className={`absolute right-2 w-2 h-2 rounded bg-green-400 ${
                        expanded ? "" : "top-2"
                    }`}
                />
            )}

            {!expanded && (
                <div
                    className={`
          w-fit absolute left-full rounded-md px-2 py-1 ml-6
          bg-green-100 text-green-800 text-sm
          invisible opacity-20 -translate-x-3 transition-all
          group-hover:visible group-hover:opacity-100 group-hover:translate-x-0
      `}
                >
                    <p className="whitespace-nowrap text-xl">{text}</p>
                </div>
            )}
        </li>
    );
}
