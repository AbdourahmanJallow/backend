import React from "react";

function SearchInput({ data, setData, onSubmit }) {
    return (
        <div className="w-full gap-4 my-5">
            <form
                onSubmit={onSubmit}
                className="space-x-2 flex justify-center items-center"
            >
                <input
                    type="text"
                    name="search"
                    value={data.search}
                    onChange={(e) => setData({ search: e.target.value })}
                    placeholder="Search for doctors..."
                    className="rounded-full p-3 w-full sm:w-96 bg-white border focus:border-blue-400 focus:outline-none"
                />
                <button
                    type="submit"
                    className="p-3 bg-blue-700 font-semibold rounded-xl text-white"
                >
                    Go
                </button>
            </form>
        </div>
    );
}

export default SearchInput;
