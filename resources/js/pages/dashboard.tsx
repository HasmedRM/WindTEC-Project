import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

type DashboardProps = { equipamentos_count?: number; wind_count?: number };

export default function Dashboard() {
    const { props } = usePage<DashboardProps>();
    const equipamentosCount = props.equipamentos_count ?? 0;
    const windCount = props.wind_count ?? 0;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <section className="grid gap-4 md:grid-cols-3">
                    <div className="rounded-xl border border-sidebar-border/70 p-4">
                        <h3 className="text-lg font-semibold">Resumo do Projeto</h3>
                        <p className="text-sm text-muted-foreground mt-2">
                            Este sistema é um ajudante virtual para técnicos: facilita a visualização de configurações, a pesquisa
                            por equipamentos e fornece tabelas para consultas manuais. Além de um chatbot
                            para suporte interativo aos técnicos.
                        </p>
                    </div>

                    <div className="rounded-xl border border-sidebar-border/70 p-4">
                        <h3 className="text-lg font-semibold">Tecnologias</h3>
                        <ul className="mt-2 space-y-2 text-sm text-muted-foreground">
                            <li>Frontend: React + Inertia + Vite</li>
                            <li>Backend: Laravel + Inertia</li>
                            <li>Banco de dados: Postgres</li>
                        </ul>
                    </div>

                    <div className="rounded-xl border border-sidebar-border/70 p-4">
                        <h3 className="text-lg font-semibold">Próximos passos</h3>
                        <ul className="mt-2 space-y-2 text-sm text-muted-foreground">
                            <li>Integrar o chatbot</li>
                            <li>Adicionar filtros nas tabelas</li>
                        </ul>
                    </div>
                </section>

                <section className="grid gap-4 md:grid-cols-2">

                    <div className="rounded-xl border border-sidebar-border/70 p-4 flex flex-col">
                        <span className="text-xs text-muted-foreground">Equipamentos</span>
                        <span className="text-2xl font-bold mt-2">{equipamentosCount}</span>
                        <a href="/EquipamentoConfig" className="mt-3 text-sm text-blue-600">Ver equipamentos</a>
                    </div>

                    <div className="rounded-xl border border-sidebar-border/70 p-4 flex flex-col">
                        <span className="text-xs text-muted-foreground">Wind</span>
                        <span className="text-2xl font-bold mt-2">{windCount}</span>
                        <a href="/WindConfig" className="mt-3 text-sm text-blue-600">Ver Wind</a>
                    </div>
                </section>
            </div>
        </AppLayout>
    );
}
