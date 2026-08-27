export default function AppLayout({children}) {
    return(
        <div>
            <header>
                <nav>nav</nav>
            </header>
            <main>
                {children}
            </main>
            <footer>footer</footer>
        </div>
    )
}
