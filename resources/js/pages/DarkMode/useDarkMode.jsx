import {useEffect, useState} from "react";

export default function useDarkMode() {
    const [darkMode, setDarkMode] = useState(() => {
        const savedMode = localStorage.getItem('theme')
        if (savedMode){
            return savedMode === 'dark'
        }

        return window.matchMedia('(prefers-color-scheme: dark)').matches
    })

    useEffect(() => {
        if (darkMode){
            document.documentElement.classList.add('dark')
            localStorage.setItem('theme','dark')
        }else{
            document.documentElement.classList.remove('dark')
            localStorage.setItem('theme','light')
        }
    }, [darkMode]);

    return {
        darkMode,
        toggleDarkMode:() => setDarkMode(dark => !dark)
    }

}
