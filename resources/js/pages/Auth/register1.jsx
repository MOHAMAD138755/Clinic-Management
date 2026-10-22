import {motion} from "motion/react"
import {useEffect, useState} from "react";
import useDarkMode from "@/pages/DarkMode/useDarkMode.jsx";

export default function register1() {

    const [form, setForm] = useState({
        name: '',
    })
    const [submitLoading, setSubmitLoading] = useState(false)
    const [error, setError] = useState({})
    const {darkMode, toggleDarkMode} = useDarkMode()
    const [loading, setLoading] = useState(true)

    useEffect(() => {
        loadingPage()
    }, [])

    function changeHandler(e) {
        const {name, value} = e.target
        setForm({
            ...form, [name]: value
        })
    }

    function validate() {
        const newError = {}

        if (!form.name.trim()) {
            newError.name = 'Name Can Not Empty'
        }
        if (form.name.length !== 11) {
            newError.name = 'Name Is Max Length! (Phone Number)'
        }
        return newError
    }

    function blueHandler() {
        setError(validate())
    }

    function submitHandler(e) {
        e.preventDefault()
        const validateError = validate()
        setError(validateError)

        if (Object.keys(validateError).length > 0) {
            return
        }
        setSubmitLoading(true)

        setTimeout(() => {
            setSubmitLoading(false)
        }, 2000)
    }

    function loadingPage() {
        setTimeout(() => {
            setLoading(false)
        }, 1000)
    }

    return (
        <motion.div initial={{opacity: 0, scale: 0.95, filter: 'blur(10px)',}}
                    animate={{opacity: 1, scale: 1, filter: 'blur(0px)',}}
                    transition={{
                        duration: 1.2,
                        ease: [0.22, 1, 0.36, 1],
                    }}
                    className={`relative w-full h-full flex justify-center items-center select-none transition-colors ${darkMode ? 'bg-gray-700 text-black' : 'bg-[#f0f2f4] text-black'}`}>
            <div className={`absolute z-[1000] flex justify-center items-center transition-opacity duration-500 ${loading ? 'opacity-100' : 'opacity-0 pointer-events-none'}`}>
                <div className='size-[80px] rounded-full border-4 border-gray-500 border-r-transparent animate-spin'></div>
            </div>
            <div className={`lg:w-[45%] md:w-[70%] w-[85%] rounded-lg ${darkMode ? 'bg-gray-300' : 'bg-[#ffffff]'}`}>
                <div className='flex justify-around items-center w-full shadow-lg '>
                    <h2 className='px-3 py-2 font-bold md:text-2xl text-xl italic'>REGISTER</h2>
                    {
                        darkMode ? (
                            <svg onClick={toggleDarkMode} xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                 fill="currentColor"
                                 className="bi bi-cloud-sun-fill cursor-pointer" viewBox="0 0 16 16">
                                <path d="M11.473 11a4.5 4.5 0 0 0-8.72-.99A3 3 0 0 0 3 16h8.5a2.5 2.5 0 0 0 0-5z"/>
                                <path
                                    d="M10.5 1.5a.5.5 0 0 0-1 0v1a.5.5 0 0 0 1 0zm3.743 1.964a.5.5 0 1 0-.707-.707l-.708.707a.5.5 0 0 0 .708.708zm-7.779-.707a.5.5 0 0 0-.707.707l.707.708a.5.5 0 1 0 .708-.708zm1.734 3.374a2 2 0 1 1 3.296 2.198q.3.423.516.898a3 3 0 1 0-4.84-3.225q.529.017 1.028.129m4.484 4.074c.6.215 1.125.59 1.522 1.072a.5.5 0 0 0 .039-.742l-.707-.707a.5.5 0 0 0-.854.377M14.5 6.5a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/>
                            </svg>
                        ) : <svg onClick={toggleDarkMode} xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                 fill="currentColor"
                                 className="bi bi-cloud-moon-fill cursor-pointer" viewBox="0 0 16 16">
                            <path d="M11.473 11a4.5 4.5 0 0 0-8.72-.99A3 3 0 0 0 3 16h8.5a2.5 2.5 0 0 0 0-5z"/>
                            <path
                                d="M11.286 1.778a.5.5 0 0 0-.565-.755 4.595 4.595 0 0 0-3.18 5.003 5.5 5.5 0 0 1 1.055.209A3.6 3.6 0 0 1 9.83 2.617a4.593 4.593 0 0 0 4.31 5.744 3.58 3.58 0 0 1-2.241.634q.244.477.394 1a4.59 4.59 0 0 0 3.624-2.04.5.5 0 0 0-.565-.755 3.593 3.593 0 0 1-4.065-5.422z"/>
                        </svg>
                    }
                </div>
                <form className='mx-auto w-[80%] my-4' onSubmit={submitHandler}>
                    <div className='w-full'>
                        <span>Enter Your User Name</span>
                        <input id='name' name='name' value={form.name}
                               onChange={changeHandler} onBlur={blueHandler}
                               type='text'
                               className={`w-full h-[50px] rounded-lg border outline-none ${error.name ? 'border-2 border-red-500' : ''} ${darkMode ? 'bg-gray-800 text-white' : 'bg-white'} border-gray-300 p-2 cursor-pointer transition-all focus:ring-1 focus:ring-blue-700`}
                        />
                        {error.name && <p className='text-red-500 text-sm'>{error.name}</p>}
                    </div>
                    <div className='w-full relative'>
                    </div>
                    <button type='submit' disabled={submitLoading}
                            className='flex my-3 justify-center items-center bg-[rgb(56,97,251)] w-full h-[40px] rounded-md text-white cursor-pointer hover:bg-blue-700 transition-all'>
                        <span className={`${submitLoading ? 'opacity-0' : 'opacity-100'}`}>Next</span>
                        {
                            submitLoading ? (
                                <div
                                    className='size-[20px] border-4 border-white rounded-full animate-spin border-t-transparent'></div>
                            ) : <div></div>
                        }
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             className={`bi bi-apple m-1 ${submitLoading ? 'opacity-0' : 'opacity-100'}`}
                             viewBox="0 0 16 16">
                            <path
                                d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516s1.52.087 2.475-1.258.762-2.391.728-2.43m3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422s1.675-2.789 1.698-2.854-.597-.79-1.254-1.157a3.7 3.7 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56s.625 1.924 1.273 2.796c.576.984 1.34 1.667 1.659 1.899s1.219.386 1.843.067c.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758q.52-1.185.473-1.282"/>
                            <path
                                d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516s1.52.087 2.475-1.258.762-2.391.728-2.43m3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422s1.675-2.789 1.698-2.854-.597-.79-1.254-1.157a3.7 3.7 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56s.625 1.924 1.273 2.796c.576.984 1.34 1.667 1.659 1.899s1.219.386 1.843.067c.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758q.52-1.185.473-1.282"/>
                        </svg>
                    </button>
                </form>
            </div>
        </motion.div>
    )
}
