import { Link, router } from "@inertiajs/react";
import { useState } from "react";
import AuthLayout from "../../Layouts/AuthLayout";

function Register() {
    const [userData, setUserData] = useState({
        name: "",
        email: "",
        password: "",
        // confirmPassword: "",
    });

    const handleChange = (e) => {
        setUserData({ ...userData, [e.target.id]: e.target.value });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        try {
            router.post("/patient/register", userData, {
                onSuccess: () => {
                    resetUserData();
                },
                onError: (errors) => {
                    console.log(errors);
                },
            });

            // resetUserData();
        } catch (error) {
            console.log(error.message);
        }
    };

    const resetUserData = () => {
        setUserData({
            name: "",
            email: "",
            // password: "",
        });
    };

    return (
        <div className="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:min-w-[400px] xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div className="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 className="text-2xl font-bold leading-tight tracking-tight text-gray-900 md:text-4xl text-center dark:text-white">
                    REGISTER{" "}
                    <span className="font-extralight italic text-lg">
                        Patient
                    </span>
                </h1>
                <form
                    onSubmit={handleSubmit}
                    className="space-y-4 md:space-y-6"
                >
                    <div>
                        <label
                            htmlFor="Name"
                            className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >
                            Your Name
                        </label>
                        <input
                            type="string"
                            name="name"
                            id="name"
                            value={userData.name}
                            onChange={handleChange}
                            className="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="John Doe"
                            required
                        />
                    </div>
                    <div>
                        <label
                            htmlFor="email"
                            className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >
                            Your email
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value={userData.email}
                            onChange={handleChange}
                            className="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="name@company.com"
                            required
                        />
                    </div>
                    <div>
                        <label
                            htmlFor="password"
                            className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >
                            Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            value={userData.password}
                            onChange={handleChange}
                            placeholder="••••••••"
                            className="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required
                        />
                    </div>

                    <button
                        type="submit"
                        className="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                    >
                        Register
                    </button>

                    <p className="text-sm font-light text-gray-500 dark:text-gray-400 w-full flex justify-between">
                        <span className="inline-flex">
                            Already have an account?{" "}
                        </span>
                        <Link
                            href="/auth/login"
                            className="font-medium text-primary-600 hover:underline dark:text-primary-500"
                        >
                            Login
                        </Link>
                    </p>
                </form>
            </div>
        </div>
    );
}

Register.layout = (page) => <AuthLayout children={page} />;

export default Register;
