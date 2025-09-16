<?php

namespace App\Http\Controllers\Dashboard\MarketAnalysis;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\AudienceConfig\Product;
// use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigStoreRequest;
// use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigUpdateRequest;
use App\Models\Dashboard\MarketAnalysis\MarketResearch;
use App\Services\Dashboard\MarketAnalysis\MarketAnalysisService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MarketAnalysisController extends Controller
{
    public function __construct(private MarketAnalysisService $marketAnalysisService) {}

    public function index(): View
    {
        $products = Product::where('user_id', Auth::id())->get();
        return view('dashboard.market_analysis.index', compact('products'));
    }

    public function create(): View
    {
        $item = new MarketResearch();

        return view('dashboard.market_analysis.create', compact('item'));
    }

    public function analyze(Request $request): View
    {
        $attributes = $request->all();
        $type = $attributes['research_type'];
        $products = Product::where('user_id', Auth::id())->get();

        // $data = match ($type) {
        //     'consumer'   => $this->marketAnalysisService->analysis($attributes),
        //     'competitor' => $this->marketAnalysisService->analysis($attributes),
        //     'trend'      => $this->marketAnalysisService->analysis($attributes),
        //     default      => null,
        // };

        // Log::info('Phân tích thị trường - Dữ liệu trend:', ['data' => $data]);


$data = [
    "success" => true,
    "type" => "trend",
    "data" => [
        "market_size" => "Ước tính khoảng 800-900 triệu USD (thị trường linh kiện PC tại Việt Nam, trong đó card đồ họa chiếm khoảng 30-35%)",
        "growth_rate" => "Dự kiến 12-15% mỗi năm (2024-2026)",
        "analysis" => "Thị trường card đồ họa tại Việt Nam vào quý 3 năm 2025 đang trải qua giai đoạn tăng trưởng ổn định nhưng có tính chọn lọc. Quy mô thị trường linh kiện PC, đặc biệt là GPU, được thúc đẩy bởi sự bùng nổ của ngành game, đặc biệt là e-sports, cùng với sự gia tăng nhu cầu về các thiết bị có hiệu năng cao cho công việc sáng tạo nội dung (thiết kế đồ họa, chỉnh sửa video, livestream). Giai đoạn hậu đại dịch đã chứng kiến sự chuyển dịch mạnh mẽ từ làm việc và giải trí tại nhà sang các hoạt động xã hội hơn, nhưng nhu cầu nâng cấp PC cá nhân vẫn duy trì do game ngày càng đòi hỏi đồ họa chân thực và các ứng dụng AI/ML cá nhân trở nên phổ biến hơn.

Các động lực chính bao gồm: 1) Tăng trưởng kinh tế ổn định tại Việt Nam, dẫn đến thu nhập khả dụng tăng và khả năng chi tiêu cho giải trí, công nghệ cao. 2) Sự phát triển không ngừng của ngành e-sports và cộng đồng streamer/content creator, tạo ra nhu cầu liên tục về phần cứng mạnh mẽ. 3) Sự phổ biến của các tựa game AAA mới với đồ họa tiên tiến và yêu cầu phần cứng cao. 4) Xu hướng 'PC custom build' ngày càng mạnh mẽ, nơi người dùng không chỉ tìm kiếm hiệu năng mà còn cả tính thẩm mỹ và cá nhân hóa sản phẩm (như phiên bản màu trắng).

Hành vi tiêu dùng đang thay đổi theo hướng tìm kiếm sự cân bằng giữa hiệu năng, giá cả và yếu tố thẩm mỹ. Người dùng không còn chỉ ưu tiên hiệu năng thô mà còn quan tâm đến hiệu quả năng lượng, khả năng tản nhiệt, độ ồn và đặc biệt là thiết kế (như card màu trắng). Phân khúc tầm trung (như RTX 3060) vẫn rất quan trọng do đáp ứng được phần lớn nhu cầu của game thủ phổ thông và người sáng tạo nội dung bán chuyên với mức giá hợp lý, đặc biệt khi các dòng card cao cấp hơn có giá thành vượt ngân sách. Tuy nhiên, họ cũng rất nhạy cảm với các đợt giảm giá hoặc ra mắt thế hệ sản phẩm mới, chờ đợi cơ hội mua sắm.

Cảnh quan cạnh tranh rất sôi động với các 'player' chính như NVIDIA (với các đối tác AIB như ASUS, MSI, Gigabyte, Zotac, Colorful) và AMD. NVIDIA vẫn chiếm thị phần lớn nhờ vào công nghệ DLSS, hiệu năng vượt trội trong nhiều tựa game và độ nhận diện thương hiệu. Colorful, với sản phẩm Colorful iGame RTX 3060 Ultra White OC, định vị mình là một thương hiệu cung cấp hiệu năng tốt với thiết kế độc đáo và mức giá cạnh tranh, thu hút những người dùng muốn PC có phong cách riêng biệt. Các thương hiệu này cạnh tranh mạnh mẽ thông qua giá, chương trình khuyến mãi, dịch vụ hậu mãi và sự đổi mới trong thiết kế sản phẩm.",
        "emerging_trends" => [
            [
                "trend" => "Sự thống trị của AI trong phát triển phần cứng và phần mềm",
                "impact_level" => "Cao",
                "description" => "Các công nghệ AI/ML đang ngày càng tích hợp sâu vào phần cứng (Tensor Cores của NVIDIA) và phần mềm (Upscaling AI như DLSS, phần mềm chỉnh sửa ảnh/video tích hợp AI, AI trong game). Điều này không chỉ nâng cao hiệu năng mà còn mở ra các ứng dụng mới, tạo động lực cho người dùng nâng cấp card đồ họa để tận dụng tối đa lợi thế AI. Các thế hệ card mới sẽ được quảng bá mạnh mẽ về khả năng xử lý AI.",
                "timeline" => "Liên tục từ Q4 2024 - Q3 2025"
            ],
            [
                "trend" => "Nhu cầu tăng về giải pháp tản nhiệt và thẩm mỹ cao cấp",
                "impact_level" => "Trung bình",
                "description" => "Với việc các bộ phận PC ngày càng mạnh mẽ và sinh nhiệt nhiều, cùng với xu hướng 'custom build' và 'desk setup' thịnh hành, người tiêu dùng không chỉ tìm kiếm card có hiệu năng mà còn có hệ thống tản nhiệt hiệu quả, độ ồn thấp và thiết kế bắt mắt (ví dụ: màu trắng, đèn RGB đồng bộ). Các phiên bản 'Ultra White OC' như sản phẩm đang phân tích sẽ có lợi thế trong phân khúc này.",
                "timeline" => "Q3 2025 - Q2 2026"
            ],
            [
                "trend" => "Đẩy mạnh phân khúc giá trị (Value Segment) và tái định vị sản phẩm thế hệ cũ",
                "impact_level" => "Cao",
                "description" => "Khi các thế hệ card đồ họa mới ra mắt (như RTX 40 series và có thể là RTX 50 series vào cuối 2025/đầu 2026), các card thế hệ trước như RTX 3060 sẽ chuyển dịch mạnh mẽ sang phân khúc 'giá trị'. Các nhà sản xuất sẽ cần tái định vị chúng như lựa chọn tối ưu cho game thủ với ngân sách hạn chế, người nâng cấp từ các dòng cũ hơn (10 series, 20 series) hoặc các cyber cafe. Cuộc chiến giá sẽ khốc liệt hơn ở phân khúc này.",
                "timeline" => "Q4 2025 - Q3 2026"
            ],
            [
                "trend" => "Mức độ quan tâm đến hiệu quả năng lượng",
                "impact_level" => "Trung bình",
                "description" => "Với chi phí điện ngày càng tăng và nhận thức về môi trường, người tiêu dùng sẽ cân nhắc nhiều hơn về hiệu quả năng lượng (Performance per Watt) của card đồ họa. Mặc dù không phải là yếu tố quyết định hàng đầu, nhưng nó sẽ là một điểm cộng đáng kể cho các sản phẩm có chỉ số này tốt.",
                "timeline" => "Q1 2026 trở đi"
            ]
        ],
        "forecast" => "Trong 6-12 tháng tới (từ Q4 2025 đến Q3 2026), thị trường card đồ họa Việt Nam dự kiến sẽ tiếp tục tăng trưởng, nhưng với sự phân hóa rõ rệt. Nhu cầu nâng cấp vẫn mạnh mẽ, đặc biệt khi các thế hệ card đồ họa mới từ NVIDIA và AMD (khả năng là RTX 50 series và RDNA 4) bắt đầu được giới thiệu hoặc rò rỉ thông tin vào cuối năm 2025, kích thích chu kỳ nâng cấp. Điều này sẽ tạo cơ hội cho việc đẩy mạnh các dòng card thế hệ cũ như RTX 3060 vào phân khúc giá trị, phục vụ game thủ có ngân sách eo hẹp hoặc các tiệm net đang có nhu cầu thay thế, nâng cấp đồng loạt. Giá của RTX 3060 dự kiến sẽ tiếp tục giảm nhẹ hoặc ổn định ở mức thấp để duy trì tính cạnh tranh với các sản phẩm tầm trung mới hơn.

Cơ hội đầu tư và phát triển sản phẩm sẽ tập trung vào: 1) Các gói sản phẩm (bundle) hấp dẫn kèm theo linh kiện khác (CPU, RAM, màn hình) hoặc game bản quyền để tăng giá trị cho các card 30-series. 2) Phát triển các dịch vụ hậu mãi, bảo hành chất lượng cao, tạo dựng niềm tin cho người dùng. 3) Đầu tư vào các phiên bản có thiết kế độc đáo và thẩm mỹ cao như 'White Edition' để phục vụ ngách thị trường 'PC custom build' đang phát triển. 4) Tập trung vào các tính năng hỗ trợ AI và quảng bá khả năng của card trong việc xử lý các tác vụ AI cá nhân, dù không phải là mạnh nhất, nhưng vẫn là một điểm bán hàng quan trọng.

Các rủi ro và thách thức tiềm ẩn bao gồm: 1) Sự ra mắt của các thế hệ card đồ họa mới có thể làm giảm mạnh nhu cầu và giá trị của các dòng cũ hơn như RTX 3060. 2) Tình hình kinh tế vĩ mô toàn cầu và trong nước có thể ảnh hưởng đến sức mua của người tiêu dùng, khiến họ trì hoãn việc nâng cấp. 3) Cạnh tranh giá khốc liệt từ các đối thủ, đặc biệt là các sản phẩm AMD tầm trung hoặc các phiên bản cũ của NVIDIA. 4) Các vấn đề về chuỗi cung ứng toàn cầu có thể gây ra biến động về giá và nguồn hàng. Để giảm thiểu rủi ro, cần có chiến lược giá linh hoạt, tập trung vào giá trị gia tăng và củng cố kênh phân phối.",
        "swot_analysis" => [
            "strengths" => ["Thị trường game, e-sports và sáng tạo nội dung tại Việt Nam đang phát triển mạnh mẽ.", "Thu nhập khả dụng của người dân tăng, thúc đẩy chi tiêu cho công nghệ.", "Sự đa dạng về sản phẩm từ các hãng lớn, đáp ứng nhiều phân khúc khách hàng.", "Công nghệ card đồ họa (Ray Tracing, DLSS/FSR) mang lại trải nghiệm hình ảnh vượt trội."],
            "weaknesses" => ["Sự phụ thuộc lớn vào chuỗi cung ứng và sản xuất chip toàn cầu.", "Biến động giá cả do các yếu tố kinh tế vĩ mô và tình trạng khan hiếm/thừa cung.", "Tốc độ phát triển công nghệ nhanh, khiến sản phẩm nhanh lỗi thời và mất giá.", "Rào cản về giá cao đối với các dòng card hiệu năng cao nhất."],
            "opportunities" => ["Nhu cầu nâng cấp từ người dùng có card đồ họa cũ (GTX 10 series, RTX 20 series).", "Sự phát triển của các phòng game/cyber cafe cần nâng cấp hệ thống hàng loạt.", "Tăng trưởng phân khúc 'PC custom build' và nhu cầu về thiết kế độc đáo, thẩm mỹ cao.", "Tiềm năng từ việc tích hợp và quảng bá các tính năng AI trong phần mềm và ứng dụng cá nhân."],
            "threats" => ["Sự ra mắt liên tục của các thế hệ card đồ họa mới gây áp lực giảm giá cho sản phẩm cũ.", "Cạnh tranh gay gắt từ các đối thủ (AMD) và các thương hiệu AIB khác.", "Rủi ro kinh tế suy thoái hoặc lạm phát ảnh hưởng đến sức mua.", "Sự phát triển của cloud gaming hoặc các giải pháp gaming thay thế có thể làm giảm nhu cầu phần cứng cục bộ."]
        ],
        "chart_data" => [
            "labels" => ["Tháng 1/2024", "Tháng 2/2024", "Tháng 3/2024", "Tháng 4/2024", "Tháng 5/2024", "Tháng 6/2024", "Tháng 7/2024", "Tháng 8/2024", "Tháng 9/2024", "Tháng 10/2024", "Tháng 11/2024", "Tháng 12/2024"],
            "actual_data" => [ 100,
                    103,
                    108,
                    112,
                    115,
                    118,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null],
            "forecast_data" => [ null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    125,
                    130,
                    138,
                    145,
                    155,
                    165],
            "trend_indicators" => ["Tăng trưởng ổn định", "Tăng trưởng nhẹ", "Tăng trưởng ổn định", "Tăng trưởng nhẹ", "Tăng trưởng nhẹ", "Tăng trưởng trung bình", "Tăng trưởng trung bình", "Tăng trưởng nhẹ", "Tăng trưởng nhẹ", "Tăng trưởng trung bình", "Tăng trưởng tốt", "Tăng trưởng tốt"]
        ],
        "recommendations" => [
            [
                "category" => "Ngắn hạn (3-6 tháng)",
                "title" => "Tối ưu hóa Chiến lược Giá và Khuyến mãi cho RTX 3060 White OC",
                "content" => "Trong bối cảnh ra mắt các dòng card mới, cần có chiến lược giá linh hoạt cho Colorful iGame RTX 3060 Ultra White OC để giữ vững vị thế ở phân khúc tầm trung. Tập trung vào các chương trình khuyến mãi theo mùa (ví dụ: Back to School, Black Friday, Tết Nguyên Đán) như giảm giá trực tiếp, tặng kèm game bản quyền, hoặc phụ kiện gaming (chuột, bàn phím) để tăng sức hấp dẫn. Đặc biệt nhấn mạnh vào yếu tố 'Ultra White' và 'OC' như những giá trị gia tăng so với đối thủ.",
                "priority" => "Cao",
                "expected_impact" => "Duy trì doanh số, giảm tồn kho, thu hút khách hàng nhạy cảm về giá và yêu thích thẩm mỹ.",
                "timeline" => "Q4 2025 - Q1 2026"
            ],
            [
                "category" => "Ngắn hạn (3-6 tháng)",
                "title" => "Tăng cường Marketing định hướng Thẩm mỹ và Cộng đồng",
                "content" => "Phát triển các chiến dịch marketing tập trung vào nhóm khách hàng 'PC custom build' và những người yêu thích thiết kế trắng độc đáo. Hợp tác với các KOLs, streamer, reviewer chuyên về PC build có gu thẩm mỹ cao để tạo ra nội dung hấp dẫn về sự kết hợp giữa hiệu năng và vẻ đẹp của sản phẩm. Tổ chức các cuộc thi 'showcase PC' với giải thưởng là sản phẩm Colorful để tạo buzz trong cộng đồng.",
                "priority" => "Cao",
                "expected_impact" => "Nâng cao nhận diện thương hiệu trong ngách thị trường 'thiết kế', tạo ra giá trị cảm tính cho sản phẩm.",
                "timeline" => "Q4 2025 - Q1 2026"
            ],
            [
                "category" => "Trung hạn (6-12 tháng)",
                "title" => "Đầu tư vào Dịch vụ Hậu mãi và Bảo hành",
                "content" => "Xây dựng và truyền thông mạnh mẽ về chính sách bảo hành, dịch vụ khách hàng chất lượng cao (ví dụ: đổi trả nhanh chóng, hỗ trợ kỹ thuật 24/7). Đối với các sản phẩm như card đồ họa, sự tin cậy và an tâm về hậu mãi là yếu tố then chốt để giữ chân khách hàng và tạo lợi thế cạnh tranh bền vững trước các đối thủ.",
                "priority" => "Trung bình",
                "expected_impact" => "Tăng cường lòng trung thành của khách hàng, nâng cao uy tín thương hiệu, giảm thiểu rủi ro sau bán hàng.",
                "timeline" => "Q1 2026 - Q3 2026"
            ],
            [
                "category" => "Trung hạn (6-12 tháng)",
                "title" => "Phát triển Quan hệ Đối tác Kênh Phân phối và Cyber Cafe",
                "content" => "Thiết lập hoặc củng cố quan hệ đối tác chiến lược với các chuỗi cửa hàng bán lẻ lớn (Phong Vũ, FPT Shop, CellphoneS) và các nhà phân phối chuyên nghiệp. Đặc biệt, tiếp cận và hợp tác với các chuỗi Cyber Cafe lớn tại Việt Nam, cung cấp giải pháp trọn gói hoặc ưu đãi đặc biệt cho việc nâng cấp dàn máy bằng RTX 3060, vì đây là phân khúc tiềm năng lớn cho các dòng card tầm trung-cũ.",
                "priority" => "Cao",
                "expected_impact" => "Mở rộng kênh tiếp cận khách hàng, tăng trưởng doanh số ổn định ở phân khúc B2B và B2C.",
                "timeline" => "Q1 2026 - Q3 2026"
            ],
            [
                "category" => "Đầu tư công nghệ và đổi mới",
                "title" => "Nghiên cứu và Phát triển các phiên bản đặc biệt mới",
                "content" => "Mặc dù RTX 3060 là thế hệ cũ, Colorful có thể tiếp tục đầu tư vào các phiên bản đặc biệt với tản nhiệt nâng cấp, hiệu suất OC cao hơn, hoặc các tính năng đèn RGB độc quyền, đặc biệt cho các thế hệ card đồ họa mới. Điều này giúp củng cố hình ảnh thương hiệu là nhà sản xuất sáng tạo và quan tâm đến chi tiết, tạo đà cho các sản phẩm thế hệ tiếp theo.",
                "priority" => "Trung bình",
                "expected_impact" => "Tạo sự khác biệt trên thị trường, thu hút khách hàng khó tính, duy trì hình ảnh thương hiệu đổi mới.",
                "timeline" => "Q2 2026 trở đi"
            ],
            [
                "category" => "Chiến lược Marketing và Brand Positioning",
                "title" => "Định vị RTX 3060 là 'Best Value for Money' với yếu tố Thẩm mỹ độc đáo",
                "content" => "Chuyển hướng thông điệp marketing cho RTX 3060 từ 'card đồ họa mạnh mẽ' sang 'lựa chọn tối ưu về hiệu năng trên giá thành, kết hợp thiết kế đẳng cấp'. Tập trung vào việc card này vẫn đủ sức cân tốt hầu hết game ở độ phân giải Full HD/2K và xử lý tốt các tác vụ sáng tạo, đồng thời mang lại vẻ đẹp độc đáo cho bộ PC. Đây là sự khác biệt chính của Colorful so với các đối thủ khác trong cùng phân khúc.",
                "priority" => "Cao",
                "expected_impact" => "Làm rõ giá trị sản phẩm, thu hút đúng đối tượng khách hàng, tránh cạnh tranh trực diện với các sản phẩm cao cấp hơn.",
                "timeline" => "Liên tục từ Q4 2025"
            ]
        ],
        "risk_assessment" => "Rủi ro tổng thể cho thị trường card đồ họa tại Việt Nam trong giai đoạn 2025-2026 là Trung bình đến Cao. Rủi ro chính đến từ việc ra mắt thế hệ GPU mới gây áp lực giảm giá cho các sản phẩm cũ như RTX 3060, cạnh tranh giá gay gắt, và các yếu tố vĩ mô như lạm phát hoặc suy giảm kinh tế có thể ảnh hưởng đến chi tiêu tiêu dùng. Rủi ro từ chuỗi cung ứng toàn cầu mặc dù đã ổn định hơn nhưng vẫn tiềm ẩn, có thể gây ra thiếu hụt hoặc tăng giá đột biến. Để giảm thiểu, doanh nghiệp cần duy trì chiến lược giá linh hoạt, có khả năng điều chỉnh nhanh chóng theo thị trường, đồng thời đa dạng hóa nguồn cung và kênh phân phối. Đầu tư vào dịch vụ hậu mãi và xây dựng cộng đồng vững chắc sẽ giúp tạo ra lợi thế cạnh tranh phi giá cả. Việc tập trung vào giá trị độc đáo của sản phẩm (như thiết kế White OC) cũng là một cách hiệu quả để phân biệt sản phẩm và giảm thiểu tác động của cuộc chiến giá.",
        "data_sources" => "Phân tích dựa trên tổng hợp thông tin từ các báo cáo thị trường ngành công nghệ và game tại Việt Nam (ví dụ: GfK, IDC, Mordor Intelligence), dữ liệu tìm kiếm người dùng từ Google Trends, khảo sát hành vi tiêu dùng từ các công ty nghiên cứu thị trường địa phương, thông tin công bố từ các nhà sản xuất chip (NVIDIA, AMD) và đối tác AIB, cùng với kinh nghiệm chuyên môn 15 năm trong ngành."
    ]
];


        return view('dashboard.market_analysis.index', compact('data', 'type', 'products'));
    }


    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->except(['_token']);

        $result = $this->marketAnalysisService->create($attributes);

        return $result
            ? redirect()->route('dashboard.market_analysis.index')->with('toast-success', __('dashboard.add_market_analysis_success'))
            : back()->with('toast-error', __('dashboard.add_market_analysis_fail'));
    }

    public function edit($id): View
    {
        $item = $this->marketAnalysisService->find($id);

        return view('dashboard.market_analysis.edit', compact('item'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $item = $this->marketAnalysisService->find($id);
        if (! $item) {
            return back()->with('toast-error', __('dashboard.not_found'));
        }

        $item = $this->marketAnalysisService->update($id, $request->all());
        if ($item) {
            return redirect()->route('dashboard.market_analysis.index')->with('toast-success', __('dashboard.update_market_analysis_success'));
        }

        return back()->with('toast-error', __('dashboard.update_market_analysis_fail'));
    }

    public function destroy($id): RedirectResponse
    {
        $isDestroy = $this->marketAnalysisService->delete($id);

        return $isDestroy
            ? redirect()->route('dashboard.market_analysis.index')->with('toast-success', __('dashboard.delete_market_analysis_success'))
            : back()->with('toast-error', __('dashboard.delete_market_analysis_fail'));
    }
}
