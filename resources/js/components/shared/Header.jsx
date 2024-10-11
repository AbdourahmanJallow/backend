import React from "react";

function Header({ title }) {
    return (
        <div className="w-full">
            <h1 className="text-3xl md:text-5xl font-bold mb-10 mt-5">
                {title}
            </h1>
        </div>
    );
}

export default Header;
