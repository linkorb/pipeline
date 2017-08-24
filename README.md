Pipeline
========

Pipeline is a library + CLI tool to load programmable pipelines, execute jobs and get detailed results per stage for reporting/debugging.

## Concepts

* Pipeline: A sequential list of stages
* Stage: An command template with a unique name within the pipeline.
* Job: A job that will be executed on a pipeline with an optional set of input variables
* JobResult: The output of a Job that has been executed on a pipeline, contains status and a StageResult for each stage in the pipeline
* StageResult: The exact command that was executed, it's exitcode, stdout and stderr.


## CLI examples

Load a pipeline YML file and execute it with input variable `topic=technology`

    bin/pipeline run examples/bbc-news-demo.pipeline.yml -d topic=technology

Load a pipeline YML file and execute it with input from STDIN

    bin/pipeline run examples/bbc-news-stdin-demo.pipeline.yml < examples/bbc-news-demo.rss.xml

Output a JSON result of the JobResult + StageResults to `result.json`

    bin/pipeline run -o result.json examples/bbc-news-demo.pipeline.yml -d topic=technology

Load a pipeline YML file and intentially cause an error by requesting a non-existant topic. This will output the errors.

    bin/pipeline run examples/bbc-news-demo.pipeline.yml -d topic=this-topic-does-not-exist

You can suppress output and debugging output by using `--quiet`. You can use this in combination with -o to read the details from a .json file.

In all cases the exit code of the pipeline command will match the exit code of the last stage result: 0 on success, or other on failure.

## Library example

Please refer to `examples/example-code.php` on how to use the pipeline package as a library.


## Configuration through environment variables

pipeline will use environment variables in the inputs of pipelines. This way you don't need to define all required variables using `-d`.

When pipeline runs, it first checks if a `.env` file exists in the current directory and update the environment variabels based on it's contents.


## License

MIT. Please refer to the [license file](LICENSE.md) for details.

## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [linkorb.com/engineering](http://www.linkorb.com/engineering).

Btw, we're hiring!
