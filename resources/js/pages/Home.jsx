import AppLayout from "@/layouts/AppLayout.jsx";

export default function Home({projects}) {
    return (
        <div className='text-center text-red-500'>this is {projects} project</div>
    )
}
Home.layout = page => <AppLayout children={page} />;
