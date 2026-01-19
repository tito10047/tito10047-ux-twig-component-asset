### Benchmark Výsledky (Nové meranie)

#### Pred Optimalizáciou (main)

| Benchmark | Mode (čas) | Memory Peak |
|-----------|------------|-------------|
| benchWarmupClassic | 23.502ms | 2.133mb |
| benchWarmupSdc | 23.535ms | 2.133mb |
| benchRenderClassic | 30.583ms | 25.890mb |
| benchRenderSdc | 29.135ms | 30.508mb |

#### Po Optimalizácii (optimizing)

| Benchmark | Mode (čas) | Memory Peak |
|-----------|------------|-------------|
| benchWarmupClassic | 23.552ms | 2.133mb |
| benchWarmupSdc | 30.067ms | 2.133mb |
| benchRenderClassic | 28.260ms | 25.890mb |
| benchRenderSdc | 29.316ms | 30.508mb |

---

*Poznámka: benchWarmupSdc v optimizing vetve vykazuje vyšší čas zrejme kvôli zmenám v kompilácii registra, kým render časy zostávajú podobné.*
