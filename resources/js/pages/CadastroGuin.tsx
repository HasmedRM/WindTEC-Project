import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, Form } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { store as guindastesStore } from '@/routes/guindastes';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/input-error';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Cadastro Guin',
        href: dashboard().url,
    },
];

export default function CadastroGuin() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Cadastro Guin" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div className="p-4">
                        <h3 className="mb-4 text-lg font-semibold">Cadastro de Guindaste</h3>
                        <p className="text-sm text-muted-foreground mb-4">
                            Preencha os dados do guindaste e clique em Salvar.
                        </p>

                        <Form {...guindastesStore.form()} method="post" className="grid gap-4">
                            {({ processing, errors }) => (
                                <>
                                    <div className="grid md:grid-cols-2 gap-4">
                                        <div className="grid gap-2">
                                            <Label htmlFor="cliente">Cliente</Label>
                                            <Input id="cliente" name="cliente" type="text" placeholder="" />
                                            <InputError message={errors.cliente} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="operacao">Operação</Label>
                                            <Input id="operacao" name="operacao" type="text" placeholder="" />
                                            <InputError message={errors.operacao} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="equipamento">Equipamento</Label>
                                            <Input id="equipamento" name="equipamento" type="text" placeholder="" />
                                            <InputError message={errors.equipamento} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="configuracao">Configuração</Label>
                                            <Input id="configuracao" name="configuracao" type="text" placeholder="" />
                                            <InputError message={errors.configuracao} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="altura_torre">Altura Torre</Label>
                                            <Input id="altura_torre" name="altura_torre" type="text" placeholder="" />
                                            <InputError message={errors.altura_torre} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="comprimento_lanca">Comprimento Lança</Label>
                                            <Input id="comprimento_lanca" name="comprimento_lanca" type="text" placeholder="" />
                                            <InputError message={errors.comprimento_lanca} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="comprimento_luffing_jib">Comprimento Luffing Jib</Label>
                                            <Input id="comprimento_luffing_jib" name="comprimento_luffing_jib" type="text" placeholder="" />
                                            <InputError message={errors.comprimento_luffing_jib} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="contrapeso">Contrapeso</Label>
                                            <Input id="contrapeso" name="contrapeso" type="text" placeholder="" />
                                            <InputError message={errors.contrapeso} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="contrapeso_ballast">Contrapeso Ballast</Label>
                                            <Input id="contrapeso_ballast" name="contrapeso_ballast" type="text" placeholder="" />
                                            <InputError message={errors.contrapeso_ballast} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="cs_12m_atv">CS 12m ATV</Label>
                                            <Input id="cs_12m_atv" name="cs_12m_atv" type="text" placeholder="" />
                                            <InputError message={errors.cs_12m_atv} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="cs_14m_atv">CS 14m ATV</Label>
                                            <Input id="cs_14m_atv" name="cs_14m_atv" type="text" placeholder="" />
                                            <InputError message={errors.cs_14m_atv} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="p4_12m_atv">P4 12m ATV</Label>
                                            <Input id="p4_12m_atv" name="p4_12m_atv" type="text" placeholder="" />
                                            <InputError message={errors.p4_12m_atv} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="p4_14m_atv">P4 14m ATV</Label>
                                            <Input id="p4_14m_atv" name="p4_14m_atv" type="text" placeholder="" />
                                            <InputError message={errors.p4_14m_atv} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="p4_12m_dolly_atv">P4 12m Dolly ATV</Label>
                                            <Input id="p4_12m_dolly_atv" name="p4_12m_dolly_atv" type="text" placeholder="" />
                                            <InputError message={errors.p4_12m_dolly_atv} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="equipamento_auxiliar_atv">Equip. Aux ATV</Label>
                                            <Input id="equipamento_auxiliar_atv" name="equipamento_auxiliar_atv" type="text" placeholder="" />
                                            <InputError message={errors.equipamento_auxiliar_atv} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="cs_12m_gdt">CS 12m GDT</Label>
                                            <Input id="cs_12m_gdt" name="cs_12m_gdt" type="text" placeholder="" />
                                            <InputError message={errors.cs_12m_gdt} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="cs_14m_gdt">CS 14m GDT</Label>
                                            <Input id="cs_14m_gdt" name="cs_14m_gdt" type="text" placeholder="" />
                                            <InputError message={errors.cs_14m_gdt} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="p4_12m_gdt">P4 12m GDT</Label>
                                            <Input id="p4_12m_gdt" name="p4_12m_gdt" type="text" placeholder="" />
                                            <InputError message={errors.p4_12m_gdt} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="p4_14m_gdt">P4 14m GDT</Label>
                                            <Input id="p4_14m_gdt" name="p4_14m_gdt" type="text" placeholder="" />
                                            <InputError message={errors.p4_14m_gdt} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="p4_12m_dolly_gdt">P4 12m Dolly GDT</Label>
                                            <Input id="p4_12m_dolly_gdt" name="p4_12m_dolly_gdt" type="text" placeholder="" />
                                            <InputError message={errors.p4_12m_dolly_gdt} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="equipamento_auxiliar_mtg">Equip. Aux MTG</Label>
                                            <Input id="equipamento_auxiliar_mtg" name="equipamento_auxiliar_mtg" type="text" placeholder="" />
                                            <InputError message={errors.equipamento_auxiliar_mtg} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="cs_12m_mtg">CS 12m MTG)</Label>
                                            <Input id="cs_12m_mtg" name="cs_12m_mtg" type="text" placeholder="" />
                                            <InputError message={errors.cs_12m_mtg} />
                                        </div>

                                        <div className="md:col-span-2 grid gap-2">
                                            <Label htmlFor="observacoes">Observações</Label>
                                            <textarea
                                                id="observacoes"
                                                name="observacoes"
                                                className="min-h-[100px] rounded-md border px-3 py-2 text-sm"
                                                placeholder="Observações sobre o guindaste"
                                            />
                                            <InputError message={errors.observacoes} />
                                        </div>
                                    </div>

                                    <div className="flex justify-end">
                                        <Button type="submit" disabled={processing}>
                                            {processing ? 'Salvando...' : 'Salvar'}
                                        </Button>
                                    </div>
                                </>
                            )}
                        </Form>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
