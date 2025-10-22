import { useNavigate } from "react-router-dom";
import { Button } from "@/components/ui/button";

export function NotFoundError() {
  const navigate = useNavigate();

  return (
    <div className="h-svh">
      <div className="m-auto flex h-full w-full flex-col items-center justify-center gap-2">
        <h1 className="text-[7rem] font-bold leading-tight">404</h1>
        <span className="font-medium">Oops! Página Não Encontrada!</span>
        <p className="text-center text-muted-foreground">
          Parece que a página que está procurando <br />
          não existe ou foi removida.
        </p>
        <div className="mt-6 flex gap-4">
          <Button variant="outline" onClick={() => navigate(-1)}>
            Voltar
          </Button>
          <Button onClick={() => navigate("/")}>Voltar ao Início</Button>
        </div>
      </div>
    </div>
  );
}
