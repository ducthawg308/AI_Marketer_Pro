from fastapi import APIRouter
from ..schemas import OptimizeRequest, OptimizeResponse
from ..services.optimize_service import optimize_content

router = APIRouter()

@router.post("/optimize-content", response_model=OptimizeResponse)
def optimize(request: OptimizeRequest):
    return optimize_content(request)
