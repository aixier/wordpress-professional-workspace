import { getAllContent } from '../lib/content';
import { writeFileSync } from 'fs';
import { join } from 'path';
import { ContentSchema } from '../lib/validators/content';

async function validateContent() {
  const types = ['blog', 'case-study', 'feature', 'doc'];
  const errors: string[] = [];

  for (const type of types) {
    try {
      const contents = await getAllContent(type);
      
      for (const content of contents) {
        try {
          ContentSchema.parse(content);
        } catch (error) {
          if (error instanceof Error) {
            errors.push(`${type}/${content.slug}: ${error.message}`);
          }
        }
      }
    } catch (error) {
      if (error instanceof Error) {
        errors.push(`Error processing ${type}: ${error.message}`);
      }
    }
  }

  if (errors.length) {
    const report = errors.join('\n');
    writeFileSync(join(process.cwd(), 'content-validation.log'), report);
    console.error('Validation errors found:');
    console.error(report);
    throw new Error('Content validation failed. See content-validation.log for details.');
  }
}

validateContent().catch(error => {
  console.error('Validation failed:', error);
  process.exit(1);
}); 