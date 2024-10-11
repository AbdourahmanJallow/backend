import { Link, router, useForm, usePage } from "@inertiajs/react";
import AuthLayout from "../../Layouts/AuthLayout";
import toast from "react-hot-toast";

function Login() {
    const { data, setData, errors, post, processing } = useForm({
        email: "von@gmail.com",
        password: "password",
    });

    const handleChange = (e) => {
        setData({ ...data, [e.target.id]: e.target.value });
    };

    // const { auth } = usePage().props;

    const handleSubmit = (e) => {
        e.preventDefault();
        try {
            post("/patient/login", data, {
                onSuccess: (page) => {
                    resetUserData();
                    // router.visit("/");
                },
                onError: (errors) => {
                    console.log(errors);
                },
            });
        } catch (error) {
            console.log(error.message);
        }
    };

    const resetUserData = () => {
        setData({
            email: "",
            // password: "",
        });
    };

    return (
        <div className="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:min-w-[400px] xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div className="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 className="text-2xl font-bold leading-tight tracking-tight text-gray-900 md:text-4xl text-center dark:text-white">
                    LOGIN{" "}
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
                            htmlFor="email"
                            className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >
                            Your email
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value={data.email}
                            onChange={handleChange}
                            className="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="name@company.com"
                            required
                        />
                    </div>
                    {errors.email && <div>{errors.email}</div>}

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
                            placeholder="••••••••"
                            value={data.password}
                            onChange={handleChange}
                            className="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required
                        />
                    </div>
                    {errors.password && <div>{errors.password}</div>}

                    <div className="flex items-center justify-between">
                        <div className="flex items-start">
                            <div className="flex items-center h-5">
                                {/* <input
                                            id="remember"
                                            aria-describedby="remember"
                                            type="checkbox"
                                            className="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
                                            required
                                        /> */}
                            </div>
                            <div className="ml-3 text-sm">
                                <label
                                    htmlFor="remember"
                                    className="text-gray-500 dark:text-gray-300"
                                >
                                    Remember me
                                </label>
                            </div>
                        </div>
                        <a
                            href="#"
                            className="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500"
                        >
                            Forgot password?
                        </a>
                    </div>
                    <button
                        type="submit"
                        className="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                    >
                        Login
                    </button>
                    <p className="text-sm font-light text-gray-500 dark:text-gray-400 w-full flex justify-between">
                        <span className="inline-flex">
                            Don't have an account yet?{" "}
                        </span>
                        <Link
                            href="/auth/register"
                            className="font-medium text-primary-600 hover:underline dark:text-primary-500"
                        >
                            Register
                        </Link>
                    </p>
                </form>
            </div>
        </div>
    );
}

Login.layout = (page) => <AuthLayout children={page} />;

export default Login;
