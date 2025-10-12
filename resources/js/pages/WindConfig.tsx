// PlaceholderPattern removed (unused)
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
// import { cadastroGuin } from '@/routes';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Link, router } from '@inertiajs/react';
import guindastesRoutes from '@/routes/guindastes';

const breadcrumbs: BreadcrumbItem[] = [
	{
		title: 'Wind Config',
		href: dashboard().url,
	},
];

export default function WindConfig() {
	const { props } = usePage<SharedData>();
	type Guindaste = {
		id: number;
		cliente?: string | null;
		altura_torre?: string | null;
		operacao?: string | null;
		equipamento?: string | null;
		configuracao?: string | null;
		comprimento_lanca?: string | null;
		comprimento_luffing_jib?: string | null;
		contrapeso?: string | null;
		contrapeso_ballast?: string | null;
		cs_12m_atv?: string | null;
		cs_14m_atv?: string | null;
		p4_12m_atv?: string | null;
		p4_14m_atv?: string | null;
		p4_12m_dolly_atv?: string | null;
		equipamento_auxiliar_atv?: string | null;
		cs_12m_gdt?: string | null;
		cs_14m_gdt?: string | null;
		p4_12m_gdt?: string | null;
		p4_14m_gdt?: string | null;
		p4_12m_dolly_gdt?: string | null;
		equipamento_auxiliar_mtg?: string | null;
		cs_12m_mtg?: string | null;
		observacoes?: string | null;
	};

	const guindastes = (props.guindastes ?? []) as Guindaste[];

	function cadastroGuin() {
		return { url: '/cadastro-guin' };
	}

	return (
		<AppLayout breadcrumbs={breadcrumbs}>
			<Head title="Wind Config" />
				{/* Data table */}
				<div className="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
					<div className="p-4">
						<h3 className="mb-4 text-lg font-semibold">Guindastes</h3>
						<div className="overflow-x-auto">
							<table className="w-full table-auto text-sm">
								<thead>
									<tr className="text-left">
										<th className="px-3 py-2">ID</th>
										<th className="px-3 py-2">Cliente</th>
										<th className="px-3 py-2">Altura Torre</th>
										<th className="px-3 py-2">Operação</th>
										<th className="px-3 py-2">Equipamento</th>
										<th className="px-3 py-2">Configuração</th>
										<th className="px-3 py-2">Compr. Lança</th>
										<th className="px-3 py-2">Compr. Luffing Jib</th>
										<th className="px-3 py-2">Contrapeso</th>
										<th className="px-3 py-2">Contrapeso Ballast</th>
										<th className="px-3 py-2">CS 12m GDT</th>
										<th className="px-3 py-2">CS 14m GDT</th>
										<th className="px-3 py-2">P4 12m GDT</th>
										<th className="px-3 py-2">P4 14m GDT</th>
										<th className="px-3 py-2">P4 12m Dolly GDT</th>
										<th className="px-3 py-2">Equip. Aux ATV</th>
										<th className="px-3 py-2">CS 12m ATV</th>
										<th className="px-3 py-2">CS 14m ATV</th>
										<th className="px-3 py-2">P4 12m ATV</th>
										<th className="px-3 py-2">P4 14m ATV</th>
										<th className="px-3 py-2">P4 12m Dolly ATV</th>
										<th className="px-3 py-2">Equip. Aux MTG</th>
										<th className="px-3 py-2">CS 12m MTG</th>
										<th className="px-3 py-2">Observações</th>
										<th className="px-3 py-2">Ações</th>
									</tr>
								</thead>
								<tbody>
									{guindastes.length === 0 && (
										<tr>
												<td colSpan={25} className="px-3 py-6 text-center text-sm text-muted-foreground">
												Nenhum guindaste cadastrado.
											</td>
										</tr>
									)}

									{guindastes.map((g: Guindaste) => (
										<tr key={g.id} className="odd:bg-muted/50">
											<td className="px-3 py-2">{g.id}</td>
											<td className="px-3 py-2">{g.cliente ?? '—'}</td>
											<td className="px-3 py-2">{g.altura_torre ?? '—'}</td>
											<td className="px-3 py-2">{g.operacao ?? '—'}</td>
											<td className="px-3 py-2">{g.equipamento ?? '—'}</td>
											<td className="px-3 py-2">{g.configuracao ?? '—'}</td>
											<td className="px-3 py-2">{g.comprimento_lanca ?? '—'}</td>
											<td className="px-3 py-2">{g.comprimento_luffing_jib ?? '—'}</td>
											<td className="px-3 py-2">{g.contrapeso ?? '—'}</td>
											<td className="px-3 py-2">{g.contrapeso_ballast ?? '—'}</td>
											<td className="px-3 py-2">{g.cs_12m_gdt ?? '—'}</td>
											<td className="px-3 py-2">{g.cs_14m_gdt ?? '—'}</td>
											<td className="px-3 py-2">{g.p4_12m_gdt ?? '—'}</td>
											<td className="px-3 py-2">{g.p4_14m_gdt ?? '—'}</td>
											<td className="px-3 py-2">{g.p4_12m_dolly_gdt ?? '—'}</td>
											<td className="px-3 py-2">{g.equipamento_auxiliar_atv ?? '—'}</td>
											<td className="px-3 py-2">{g.cs_12m_atv ?? '—'}</td>
											<td className="px-3 py-2">{g.cs_14m_atv ?? '—'}</td>
											<td className="px-3 py-2">{g.p4_12m_atv ?? '—'}</td>
											<td className="px-3 py-2">{g.p4_14m_atv ?? '—'}</td>
											<td className="px-3 py-2">{g.p4_12m_dolly_atv ?? '—'}</td>
											<td className="px-3 py-2">{g.equipamento_auxiliar_mtg ?? '—'}</td>
											<td className="px-3 py-2">{g.cs_12m_mtg ?? '—'}</td>
											<td className="px-3 py-2">{g.observacoes ?? '—'}</td>
											<td className="px-3 py-2">
												<div className="flex gap-2">
													<Link href={guindastesRoutes.edit(g.id).url} className="text-blue-600">Editar</Link>
													<Button variant="destructive" size="sm" onClick={() => {
														if (!confirm('Tem certeza que deseja deletar este guindaste?')) return;
														router.delete(guindastesRoutes.destroy(g.id).url);
													}}>
														Deletar
													</Button>
												</div>
											</td>
										</tr>
									))}
								</tbody>
							</table>
						</div>

						<div className="mt-4 flex justify-end">
							<Button asChild>
								<a href={cadastroGuin().url} className="inline-block">Cadastrar</a>
							</Button>
						</div>
					</div>
				</div>
		</AppLayout>
	);
}
