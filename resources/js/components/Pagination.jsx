import { router } from "@inertiajs/react";
import React from "react";

function Pagination({ links, currentPage, setCurrentPage }) {
    const handlePageChange = (url) => {
        const pageParam = new URL(url).searchParams.get("page");
        setCurrentPage(pageParam);

        router.get(url, { preserveState: true });

        // setCurrentPage(parseInt(url.split("page=")[1]));
    };

    return (
        <nav className="flex justify-center mt-5">
            <ul className="flex justify-start">
                {links.map((link) => (
                    <li
                        key={link.label}
                        className={`cursor-pointer text-lg px-2 py-0.5 rounded border border-slate-100  ${
                            link.active
                                ? "bg-blue-700 text-white"
                                : "bg-white text-blue-700"
                        }`}
                    >
                        <a
                            href={link.url}
                            onClick={(e) => {
                                e.preventDefault();
                                handlePageChange(link.url);
                            }}
                            dangerouslySetInnerHTML={{ __html: link.label }}
                        />
                    </li>
                ))}
            </ul>
        </nav>
    );
}

export default Pagination;
